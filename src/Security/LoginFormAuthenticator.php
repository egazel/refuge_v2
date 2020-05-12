<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\LoginAttempt;
use App\Services\RedirectService;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoginAttemptRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $loginAttemptRepository;
    private $userRepository;
    private $mailer; 
    private $redirection;

    public function __construct(RedirectService $redirection, MailerInterface $mailer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, LoginAttemptRepository $loginAttemptRepository, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->loginAttemptRepository = $loginAttemptRepository;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->redirection = $redirection;
    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $userMail = $request->request->get('email');
      
        $currentUser = $this->userRepository->findOneByEmail($userMail);
        $savedBrowserForCurrentUser = $currentUser->getUsualBrowser();

        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
          $bname = 'Internet Explorer';
        }elseif(preg_match('/Firefox/i',$u_agent)){
          $bname = 'Mozilla Firefox';
        }elseif(preg_match('/OPR/i',$u_agent)){
          $bname = 'Opera';
        }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
          $bname = 'Google Chrome';
        }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
          $bname = 'Apple Safari';
        }elseif(preg_match('/Netscape/i',$u_agent)){
          $bname = 'Netscape';
        }elseif(preg_match('/Edge/i',$u_agent)){
          $bname = 'Edge';
        }elseif(preg_match('/Trident/i',$u_agent)){
          $bname = 'Internet Explorer';
        }

        if ($bname != $savedBrowserForCurrentUser) {
            if ($savedBrowserForCurrentUser!=NULL){

                $email = (new TemplatedEmail())->from(new Address('samappagency@gmail.com', 'Artisans App'))
                                                        ->to(new Address('samappagency@gmail.com', $currentUser->getUsername()))
                                                        ->subject('Nouveau navigateur détecté')
                                                        ->htmlTemplate('email/browser.html.twig')
                                                        ->context([
                                                            'user' => $currentUser
                                                        ]);
                $this->mailer->send($email);
               
                $flashBag = $request->getSession()->getFlashBag();
                $flashBag->add(
                    'danger',
                    'Merci de valider votre navigateur via le mail que nous vous avons envoyé.'
                );
                $currentUser->setUsualBrowser($bname);
              
            } else {
                $currentUser->setUsualBrowser($bname);
            }
        }

        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        $newLoginAttempt = new LoginAttempt($request->getClientIp(), $credentials['email']);

        $this->entityManager->persist($newLoginAttempt);
        $this->entityManager->flush();

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->loginAttemptRepository->countRecentLoginAttempts($credentials['email']) > 3) {
            $email = (new TemplatedEmail())->from(new Address('samappagency@gmail.com', 'Artisans App'))
                                                   ->to(new Address('samappagency@gmail.com', $user->getUsername()))
                                                   ->subject('Tentative de connexion sur votre compte')
                                                   ->htmlTemplate('email/security.html.twig')
                                                   ->context([
                                                       'user' => $user
                                                   ]);
    
            $this->mailer->send($email);
            throw new CustomUserMessageAuthenticationException('Trop de tentatives de connexion d\'affilée. Veuillez patienter avant de re-essayer');
        }
        
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('admin'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
