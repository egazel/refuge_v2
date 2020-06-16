<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
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
    public function index()
    {
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
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
    public function eventsToCome()
    {
        return $this->render('member/eventsToCome.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
      * @IsGranted("ROLE_MEMBER")
     * @Route("/member/makeDonation", name="makeDonation")
     */
    public function makeDonation()
    {
        return $this->render('member/doDonation.html.twig', [
            'controller_name' => 'MemberController',
        ]);
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
