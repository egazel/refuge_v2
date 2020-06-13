<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Animal;
use App\Form\AnimalType;
use App\Form\RegistrationFormType;
use App\Repository\AnimalRepository;
use App\Repository\GerantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $nextEvent = $this->getDoctrine()->getRepository('App:Event')->findOneByNextDate();
        $participatingMembers = $nextEvent->getParticipatingMembers();
        $participatingUsersMail = [];
        for ($i=0; $i<count($participatingMembers); $i++){
            array_push($participatingUsersMail, $participatingMembers[$i]->getUser()->getEmail());
        }
     
        $donations = $this->getDoctrine()->getRepository('App:Donation')->findThreeByLatest();
        return $this->render('admin/index.html.twig',
        ['nextEvent' => $nextEvent, 'participatingUsers' => $participatingUsersMail, 'donations' => $donations,],
        );
    }

    /** 
    * @IsGranted("ROLE_ADMIN")
    * @Route("/admin/animalList", name="animalList")
    */
    public function animalList(GerantRepository $gerantRepository, AnimalRepository $animalRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $animal = new Animal();
        $gerant = $gerantRepository->findOneByUser($this->getUser());
        $addAnimalForm = $this->createForm(AnimalType::class, $animal);
        $addAnimalForm->handleRequest($request);
        $isModalValid = true;

        if ($addAnimalForm->isSubmitted()) {
            if ($addAnimalForm->isValid()){
                $animal->setGerant($gerant);
                $animal->setIsHosted(false);
                $animal->setDateAdd(new \DateTime('now'));
                $entityManager->persist($animal);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'L\'animal a bien été ajouté !'
                );
                $animal = new Animal();
                $addAnimalForm = $this->createForm(AnimalType::class, $animal);
                $this->redirectToRoute('animalList', ['addAnimalForm' => $addAnimalForm->createView()]);
            } else {
                $isModalValid = false;
            }
        }
        $animals = $animalRepository->findAll();
        return $this->render('admin/animalList.html.twig', 
            ['animals' => $animals, 'addAnimalForm' => $addAnimalForm->createView(), 'isModalValid' => $isModalValid]);
    }

    /** 
    * @IsGranted("ROLE_ADMIN")
    * @Route("/admin/userList", name="userList")
    */
    public function userList()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('admin/userList.html.twig', 
        ['users' => $users]);
    }

    /** 
    * @IsGranted("ROLE_ADMIN")
    * @Route("/admin/eventList", name="eventList")
    */
    public function eventList()
    {
        $events = $this->getDoctrine()->getRepository('App:Event')->findAll();
        
        return $this->render('admin/eventList.html.twig', 
        ['events' => $events]);
    }

    /** 
    * @IsGranted("ROLE_ADMIN")
    * @Route("/admin/donationsList", name="donationsList")
    */
    public function donationsList()
    {
        $donations = $this->getDoctrine()->getRepository('App:Donation')->findAll();
        $donationMailsArray = [];
        foreach ($donations as $don) {
         
            $donatingMemberId= $don->memberDonating->getId();
            $userCorresponding = $this->getDoctrine()->getRepository('App:User')->findByMemberId($donatingMemberId);
            $mail = $userCorresponding[0]->getEmail();
            array_push($donationMailsArray, $mail);
        }
        return $this->render('admin/donationsList.html.twig', 
        ['donations' => $donations, 'donationsIds' => $donationMailsArray],);
    }

    /** 
    * @IsGranted("ROLE_ADMIN")
    * @Route("/admin/fosterRequests", name="fosterRequests")
    */
    public function fosterRequests()
    {
        return $this->render('admin/fosterRequests.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }
}
