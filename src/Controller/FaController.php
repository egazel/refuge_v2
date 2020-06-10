<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FaController extends AbstractController
{
    /**
     * @Route("/fa", name="fa")
     */
    public function index()
    {
        return $this->render('fa/index.html.twig', [
            'controller_name' => 'FaController',
        ]);
    }

    /**
     * @Route("/fa/hostAnimal", name="hostAnimal")
     */
    public function hostAnimal()
    {
        return $this->render('fa/animalsToHost.html.twig', [
            'controller_name' => 'FaController',
        ]);
    }

    /**
     * @Route("/fa/eventsToCome", name="FAeventsToCome")
     */
    public function FAeventsToCome()
    {
        return $this->render('fa/eventsToCome.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }

    /**
     * @Route("/fa/makeDonation", name="FAmakeDonation")
     */
    public function FAmakeDonation()
    {
        return $this->render('fa/doDonation.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
