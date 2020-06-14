<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Membre;
use Symfony\Component\Form\Form;
use App\Form\RegistrationFormType;
use App\Repository\MembreRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(ValidatorInterface $validator, GoogleAuthenticatorInterface $googleAuthenticatorInterface, Request $request, UserPasswordEncoderInterface $passwordEncoder, MembreRepository $membreRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $violations = $validator->validate($form->get('plainPassword')->getNormData(), [
                new NotCompromisedPassword(),
            ]);

            // If compromised assign the error to the password field
            if ($user->getCheckPassword() && $violations instanceof ConstraintViolationList && $violations->count()) {
                $password = $form->get('plainPassword');
                if ($password instanceof Form) {
                    $violationMessage = "Ce mot de passe a été divulgué lors d'une violation de données, il ne doit pas être utilisé. Veuillez utiliser un autre mot de passe.";
                    $password->addError(new FormError((string) $violationMessage));
                }
            } else {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $user->setGoogleAuthenticatorSecret($googleAuthenticatorInterface->generateSecret());

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
                $user->setUsualBrowser($bname);
                
                $user->setRoles(["ROLE_MEMBER"]);
                
                $membre = new Membre();
                $membre->setUser($user);
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->persist($membre);
                $entityManager->flush();

                // do anything else you need here, like send an email
               

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
