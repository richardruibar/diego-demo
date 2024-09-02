<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
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

    private function getConfiguredClient(): KernelBrowser
    {
        $client = static::createClient();
        $client->setServerParameter(
            'HTTP_HOST',
            $this->fetchHost()
        );

        return $client;
    }

    private function fetchHost(): string
    {
        $host = $this->getContainer()->getParameter('app.host');

        if (!is_string($host)) {
            throw new \InvalidArgumentException('app.host param must be string');
        }

        return $host;
    }
}
