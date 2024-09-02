<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = $this->getConfiguredClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Příspěvky');
    }

    private function getConfiguredClient(): \Symfony\Bundle\FrameworkBundle\KernelBrowser|\Symfony\Component\BrowserKit\AbstractBrowser|null
    {
        $client = static::createClient();
        $client->setServerParameter(
            'HTTP_HOST',
            $this->getContainer()->getParameter('app.host')
        );

        return $client;
    }
}
