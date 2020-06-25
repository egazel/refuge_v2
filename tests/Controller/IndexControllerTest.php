<?php 
namespace App\Tests\Controller;

use App\Controller\IndexController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // create a client : mimicking someone browsing the website.
        $client = static::createClient();

        // request access to the route '/'
        $client->request('GET', '/');

        // Assert that the result returned is code 200, meaning the page is up.
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
?>