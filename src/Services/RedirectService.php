<?php
namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedirectService extends AbstractController
{
    public function redirectToRouteCustom(String $routeName){
        return $this->redirectToRoute($routeName);
    }
}

?>