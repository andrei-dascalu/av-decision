<?php

namespace Decision\DecisionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    $client = static::createClient();

    $crawler = $client->request('GET', '/hello/Fabien');

    $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() == 0);
}
