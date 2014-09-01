<?php

namespace Decision\DecisionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Decision\DecisionBundle\Controller\PlayerController;

class PlayerControllerTest extends WebTestCase
{
     $client = static::createClient();

    $crawler = $client->request('GET', '/hello/Fabien');

    $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() == 0);
}
