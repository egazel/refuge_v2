<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\MakeDonationType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\AnimalRepository;
use App\Repository\MembreRepository;
use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemberController extends AbstractController
{
    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/member", name="member")
     */
    public function index(AnimalRepository $animalRepository, EventRepository $eventRepository, DonationRepository $donationRepository, UserRepository $userRepository)
    {
        $oldestAnimals = $animalRepository->getThreeOldestAnimals();
        $newestAnimals = $animalRepository->getThreeNewestAnimals();
        $events = $eventRepository->findAll();
        $donations = $donationRepository->findAll();
        $donorsMail = [];
        for ($i=0; $i < count($donations); $i++){
           $tmp = $userRepository->findByMemberId($donations[$i]->getMemberDonatingId());
           array_push($donorsMail, $tmp[0]->getEmail());
        }

        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
            'oldestAnimals' => $oldestAnimals,
            'newestAnimals' => $newestAnimals,
            'events' => $events,
            'donations' => $donations,
            'donorsMail' => $donorsMail
        ]);
    }

    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/member/animalsToAdopt", name="animalsToAdopt")
     */
    public function animalsToAdopt(AnimalRepository $animalRepository)
    {
        $animals = $animalRepository->findAll();
        return $this->render('member/animalsToAdopt.html.twig', [
            'controller_name' => 'MemberController',
            'animals' => $animals
        ]);
    }

    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/moreInformations", name="moreInformations", options={"expose"=true})
     */
    public function moreInformations(AnimalRepository $animalRepository, Request $request, SerializerInterface $serializerInterface)
    {
        $animalDetail = $animalRepository->findOneById($request->query->get('id'));
        $animalJson = $serializerInterface->serialize($animalDetail, 'json');
        return $this->json($animalJson);
    }

    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/member/eventsToCome", name="eventsToCome")
     */
    public function eventsToCome(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();

        return $this->render('member/eventsToCome.html.twig', [
            'controller_name' => 'MemberController',
            'events' => $events
        ]);
    }

    /**
      * @IsGranted("ROLE_MEMBER")
     * @Route("/member/makeDonation", name="makeDonation")
     */
    public function makeDonation(MembreRepository $membreRepository, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $donation = new Donation();
        $makeDonationForm = $this->createForm(MakeDonationType::class, $donation);
        $makeDonationForm->handleRequest($request);
        $membreId = $membreRepository->findOneByUser($this->getUser());
        if ($makeDonationForm->isSubmitted()) {
            if ($makeDonationForm->isValid()){
                $donation->setMemberDonatingId($membreId);
                $donation->setDate(new \DateTime('now'));
                $entityManager->persist($donation);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Merci pour votre donation !'
                );
                $donation = new Donation();
                $makeDonationForm = $this->createForm(MakeDonationType::class, $donation);
                
                $this->redirectToRoute('makeDonation', ['makeDonationForm' => $makeDonationForm->createView()]);
            }
        }

        return $this->render('member/doDonation.html.twig', [
            'controller_name' => 'MemberController', 'makeDonationForm' => $makeDonationForm->createView()]);
    }

    /**
      * @IsGranted("ROLE_MEMBER")
     * @Route("/member/becomeFoster", name="becomeFoster")
     */
    public function becomeFoster()
    {
        return $this->render('member/becomeFoster.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
