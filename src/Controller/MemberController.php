<?php

namespace App\Controller;

use App\Entity\FA;
use App\Entity\Donation;
use App\Form\MakeDonationType;
use App\Form\MemberToFosterType;
use App\Repository\FARepository;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\AnimalRepository;
use App\Repository\MembreRepository;
use App\Repository\DonationRepository;
use App\Repository\HouseTypeRepository;
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
    public function index(AnimalRepository $animalRepository, EventRepository $eventRepository, DonationRepository $donationRepository, MembreRepository $membreRepository, UserRepository $userRepository)
    {
        $oldestAnimals = $animalRepository->getThreeOldestAnimals();
        $newestAnimals = $animalRepository->getThreeNewestAnimals();
        $events = $eventRepository->findAll();
        $membre = $membreRepository->findOneByUser($this->getUser());
        $donations = $donationRepository->findByMemberDonating($membre);
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
            'oldestAnimals' => $oldestAnimals,
            'newestAnimals' => $newestAnimals,
            'events' => $events,
            'donations' => $donations
        ]);
    }

    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/member/animalsToAdopt", name="animalsToAdopt")
     */
    public function animalsToAdopt(AnimalRepository $animalRepository)
    {
        $animals = $animalRepository->findByMember(NULL);
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
        $animalJson = $serializerInterface->serialize($animalDetail, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return $this->json($animalJson, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @IsGranted("ROLE_MEMBER")
     * @Route("/member/adoptAnimal/{id}", name="adoptAnimal")
     */
    public function adoptAnimal($id, AnimalRepository $animalRepository, MembreRepository $membreRepository, EntityManagerInterface $entityManager)
    {
        $animals = $animalRepository->findByMember(NULL);

        $animal = $animalRepository->findOneById($id);
        $membre = $membreRepository->findOneByUser($this->getUser());

        $animal->setMember($membre);
        $membre->addAnimalsAdopted($animal);

        $entityManager->persist($animal);
        $entityManager->persist($membre);
        $entityManager->flush();

        return $this->render('member/animalsToAdopt.html.twig', [
            'controller_name' => 'MemberController',
            'animals' => $animals
        ]);
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
        $membre = $membreRepository->findOneByUser($this->getUser());
        if ($makeDonationForm->isSubmitted()) {
            if ($makeDonationForm->isValid()){
                $donation->setMemberDonating($membre);
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
    public function becomeFoster(UserRepository $userRepository, DonationRepository $donationRepository, EventRepository $eventRepository, MembreRepository $membreRepository, FARepository $faRepository, Request $request, EntityManagerInterface $entityManager, HouseTypeRepository $houseTypeRepository)
    {
        $foster = new FA();
        $memberToFosterForm = $this->createForm(MemberToFosterType::class, $foster);
        $memberToFosterForm->handleRequest($request);
        $isModalValid = true;

        if ($memberToFosterForm->isSubmitted()) {
            if ($memberToFosterForm->isValid()){
                $user=$this->getUser();
                $user->setRoles(['ROLE_FA']);
                $foster->setUser($user);
                
                $membre = $membreRepository->findByUser($user);
                if ($membre != []){
                    $donations = $membre[0]->getDonation();
                    if (count($donations)>0){
                        for($i=0;$i<count($donations);$i++){
                            $entityManager->remove($donations[$i]);
                        }
                    }

                    $events = $membre[0]->getEvent();
                    if (count($events)>0){
                        for($i=0;$i<count($events);$i++){
                            $entityManager->remove($events[$i]);
                        }
                    }

                    $entityManager->remove($membre[0]);
                }

                $entityManager->persist($foster);
                $entityManager->persist($user);

                $entityManager->flush();
                $foster = new FA();
                $memberToFosterForm = $this->createForm(MemberToFosterType::class, $foster);
                $this->redirectToRoute('fa');
                $this->addFlash(
                    'success',
                    'Vous êtes désormais une famille d\'accueil ! Merci de vous déconnecter/reconnecter'
                );
            } else {
                $isModalValid = false;
            }
        }
        return $this->render('member/becomeFoster.html.twig', [
            'controller_name' => 'MemberController',
            'memberToFosterForm' => $memberToFosterForm->createView(),
            'isModalValid' => $isModalValid
        ]);
    }
}
