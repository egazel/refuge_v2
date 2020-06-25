<?php 
namespace App\Tests\Entity;
use App\Entity\User;

class UserTest
{
   public function testGetRoles(){
        $this->user->setRoles('ROLE_ADMIN');
        $this->assertEquals("[ROLE_ADMIN]", $this->user->getRoles());
    }

    public function testGetEmail(){
        $this->user->setEmail('elie@gazel.net');
        $this->assertEquals("elie@gazel.net", $this->user->getEmail());
    }
}
?>