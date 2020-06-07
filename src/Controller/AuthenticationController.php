<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    /**
     * @Route("/authentication", name="authentication")
     */
    public function index()
    {
        return $this->render('authentication/index.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }

    /**
     * @Route("/FA", name="FA")
     */
    public function FA()
    {
        return $this->render('FA/index.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }

      /**
     * @Route("/member", name="member")
     */
    public function member()
    {
        return $this->render('member/index.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }
}
