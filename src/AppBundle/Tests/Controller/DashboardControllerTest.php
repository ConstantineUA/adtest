<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testRedirectToLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dashboard/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('input#username')->count() == 1);
        $this->assertTrue($crawler->filter('input#password')->count() == 1);
        $this->assertTrue($crawler->filter('input#_submit')->count() == 1);
    }
}
