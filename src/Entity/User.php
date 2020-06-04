<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, TwoFactorInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="googleAuthenticatorSecret", type="string", nullable=true)
     */
    private $googleAuthenticatorSecret;

    /**
     *
     * @var boolean
     */
    private $checkPassword;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $usual_browser;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Gerant", mappedBy="userRole", cascade={"persist", "remove"})
     */
    private $isGerant;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FA", mappedBy="userRole", cascade={"persist", "remove"})
     */
    private $isFA;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Member", mappedBy="userRole", cascade={"persist", "remove"})
     */
    private $isMember;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorSecret ? true : false;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->getUsername();
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }

    /**
     * Get the value of checkPassword
     */ 
    public function getCheckPassword()
    {
        return $this->checkPassword;
    }

    /**
     * Set the value of checkPassword
     *
     * @return  self
     */ 
    public function setCheckPassword($checkPassword)
    {
        $this->checkPassword = $checkPassword;

        return $this;
    }

    public function getUsualBrowser(): ?string
    {
        return $this->usual_browser;
    }

    public function setUsualBrowser(?string $usual_browser): self
    {
        $this->usual_browser = $usual_browser;

        return $this;
    }

    public function getIsGerant(): ?Gerant
    {
        return $this->isGerant;
    }

    public function setIsGerant(?Gerant $isGerant): self
    {
        $this->isGerant = $isGerant;

        // set (or unset) the owning side of the relation if necessary
        $newUserRole = null === $isGerant ? null : $this;
        if ($isGerant->getUserRole() !== $newUserRole) {
            $isGerant->setUserRole($newUserRole);
        }

        return $this;
    }

    public function getIsFA(): ?FA
    {
        return $this->isFA;
    }

    public function setIsFA(?FA $isFA): self
    {
        $this->isFA = $isFA;

        // set (or unset) the owning side of the relation if necessary
        $newUserRole = null === $isFA ? null : $this;
        if ($isFA->getUserRole() !== $newUserRole) {
            $isFA->setUserRole($newUserRole);
        }

        return $this;
    }

    public function getIsMember(): ?Member
    {
        return $this->isMember;
    }

    public function setIsMember(?Member $isMember): self
    {
        $this->isMember = $isMember;

        // set (or unset) the owning side of the relation if necessary
        $newUserRole = null === $isMember ? null : $this;
        if ($isMember->getUserRole() !== $newUserRole) {
            $isMember->setUserRole($newUserRole);
        }

        return $this;
    }
}
