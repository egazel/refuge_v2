<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /** 
    * @Route("/admin/animalList", name="animalList")
    */
    public function animalList()
    {
        return $this->render('admin/animalList.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }

    /** 
    * @Route("/admin/userList", name="userList")
    */
    public function userList()
    {
        return $this->render('admin/userList.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }

    /** 
    * @Route("/admin/eventList", name="eventList")
    */
    public function eventList()
    {
        return $this->render('admin/eventList.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }

    /** 
    * @Route("/admin/donationsList", name="donationsList")
    */
    public function donationsList()
    {
        return $this->render('admin/donationsList.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }

    /** 
    * @Route("/admin/fosterRequests", name="fosterRequests")
    */
    public function fosterRequests()
    {
        return $this->render('admin/fosterRequests.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }
}
