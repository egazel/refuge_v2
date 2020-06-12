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
    * @Route("/admin/animalList", name="animalList")
    */
    public function animalList()
    {
        $animals = $this->getDoctrine()->getRepository('App:Animal')->findAll();

        return $this->render('admin/animalList.html.twig', 
        ['animals' => $animals]);
    }

    /** 
    * @Route("/admin/userList", name="userList")
    */
    public function userList()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('admin/userList.html.twig', 
        ['users' => $users]);
    }

    /** 
    * @Route("/admin/eventList", name="eventList")
    */
    public function eventList()
    {
        $events = $this->getDoctrine()->getRepository('App:Event')->findAll();
        
        return $this->render('admin/eventList.html.twig', 
        ['events' => $events]);
    }

    /** 
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
    * @Route("/admin/fosterRequests", name="fosterRequests")
    */
    public function fosterRequests()
    {
        return $this->render('admin/fosterRequests.html.twig', [
            'controller_namer' => 'AdminController',
        ]);
    }
}
