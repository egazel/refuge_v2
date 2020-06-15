<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $superAdmin = new User();
        $superAdmin->setEmail("admin@admin.fr");
        $superAdmin->setRoles(["ROLE_SUPER_ADMIN"]);
        $superAdmin->setPassword($this->passwordEncoder->encodePassword($superAdmin, "password"));
        $superAdmin->setUsualBrowser("Google Chrome");
        $superAdmin->setRegisterDate(new \DateTime('now'));

        
        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, "password"));
        $admin->setUsualBrowser("Google Chrome");
        $admin->setRegisterDate(new \DateTime('now'));
        

        $user = new User();
        $user->setEmail("member1@member.fr");
        $user->setRoles(["ROLE_MEMBER"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, "password"));
        $user->setUsualBrowser("Google Chrome");
        $user->setRegisterDate(new \DateTime('now'));
        

        $user2 = new User();
        $user2->setEmail("member2@member.fr");
        $user2->setRoles(["ROLE_MEMBER"]);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, "password"));
        $user2->setUsualBrowser("Google Chrome");
        $user2->setRegisterDate(new \DateTime('now'));
        
        $manager->persist($superAdmin);
        $manager->persist($admin);
        $manager->persist($user);
        $manager->persist($user2);

        $manager->flush();
    }
}
