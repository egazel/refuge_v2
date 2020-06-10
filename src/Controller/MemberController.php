<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     */
    public function index()
    {
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
     * @Route("/member/animalsToAdopt", name="animalsToAdopt")
     */
    public function animalsToAdopt()
    {
        return $this->render('member/animalsToAdopt.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
     * @Route("/member/eventsToCome", name="eventsToCome")
     */
    public function eventsToCome()
    {
        return $this->render('member/eventsToCome.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

     /**
     * @Route("/member/makeDonation", name="makeDonation")
     */
    public function makeDonation()
    {
        return $this->render('member/doDonation.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
