<?php

namespace App\Tests\Admin;

use App\DataFixtures\TestFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentTest extends WebTestCase
{
    public function testCommentList(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::ADMIN_EMAIL]);
        /** @var User|UserInterface $testUser */
        $client->loginUser($testUser);

        $client->request('GET', '/admin/app/post/list');
        $crawler = $client->clickLink('Komentáře (7)');
        $this->assertSelectorTextContains('.navbar-header', 'Nevíš nikdy nic');
        $this->assertAnySelectorTextContains('td', '3 Tehdy jsem šla za.');
        $this->assertAnySelectorTextContains('td', 'Nevíš nikdy nic');
        $this->assertAnySelectorTextContains('td', '1.5.2018 01:01:55');
        $this->assertAnySelectorTextContains('td', '3 Když pak se ho.');
        $this->assertAnySelectorTextContains('td', '16.3.2000 04:47:14');

        $this->assertAnySelectorTextContains('td .btn', 'Odstranit soft');
        $this->assertAnySelectorTextContains('td .btn', 'Odstranit hard');
        $this->assertAnySelectorTextContains('td .btn', 'Upravit');

        // 2 Soft deleted comments
        $this->assertEquals(2, $crawler->filter('.btn.delete_hard')->count());

        $this->assertAnySelectorTextContains('div.pull-right', '7 záznamů');
    }

    public function testSoftDeletion(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::ADMIN_EMAIL]);
        /** @var User|UserInterface $testUser */
        $client->loginUser($testUser);

        // Assert that the comment is present on the post page
        $crawler = $client->request('GET', '/post/nevis-nikdy-nic');
        $this->assertSelectorCount(5, 'article h3');
        /** @noinspection CssInvalidPseudoSelector */
        $this->assertEquals(
            1,
            $crawler->filter('article h3:contains("3 Když pak se ho.")')->count()
        );

        // Go to comments page
        $client->request('GET', '/admin/app/post/list');
        $crawler = $client->clickLink('Komentáře (7)');

        // Remove comment
        $client->clickLink('Odstranit soft');
        $client->submitForm('Ano, odstranit');
        $client->followRedirect();
        $this->assertSelectorTextContains('.navbar-header', 'Nevíš nikdy nic');
        $this->assertSelectorTextContains('.alert-success', 'Položka byla úspěšně odstraněna.');

        // 3 Soft deleted comments
        $this->assertEquals(2, $crawler->filter('.btn.delete_hard')->count());

        // Assert that the number of comments on homepage is correct
        $client->request('GET', '/');
        $this->assertAnySelectorTextContains('span.comments-count', '4 komentáře');


        // Assert that the comment is not present on the post page
        $crawler = $client->clickLink('Celý příspěvek');
        $this->assertSelectorTextContains('h1', 'Nevíš nikdy nic');
        $this->assertSelectorCount(4, 'article h3');
        /** @noinspection CssInvalidPseudoSelector */
        $this->assertEquals(
            0,
            $crawler->filter('article h3:contains("3 Když pak se ho.")')->count()
        );
    }
}
