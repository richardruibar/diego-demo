<?php

namespace App\Tests\Admin;

use App\DataFixtures\TestFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class AccessTest extends WebTestCase
{
    public function testAnonymousUserCanNotAccessAdmin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/dashboard');
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Přihlaste se prosím');
    }

    public function testUnprivilegedUserCanNotAccessAdmin(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        /** @var User|UserInterface $testUser */
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::USER_EMAIL]);
        $client->loginUser($testUser);

        $client->request('GET', '/admin/dashboard');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminCanAccessAdmin(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::ADMIN_EMAIL]);
        /** @var User|UserInterface $testUser */
        $client->loginUser($testUser);

        $client->request('GET', '/admin/dashboard');
        $this->assertSelectorTextContains('a.logo span', 'Diego Admin');
    }

    public function testLoginAndLogout(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $client->clickLink('Admin login');
        $this->assertSelectorTextContains('h1', 'Přihlaste se prosím');

        $client->submitForm('Přihlásit', [
            '_username' => TestFixtures::ADMIN_EMAIL,
            '_password' => TestFixtures::ADMIN_PASSWORD,
        ]);

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $this->assertAnySelectorTextContains('h1', 'Příspěvky');
        $client->request('GET', '/admin/dashboard');
        $client->clickLink('Odhlásit');
        $client->followRedirect();
        $this->assertAnySelectorTextContains('h1', 'Příspěvky');
        $client->request('GET', '/admin/dashboard');
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Přihlaste se prosím');
    }
}
