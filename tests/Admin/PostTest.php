<?php

namespace App\Tests\Admin;

use App\DataFixtures\TestFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Helper\SonataFormHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class PostTest extends WebTestCase
{
    private const string TITLE = 'Nový titulek';
    private const string AUTHOR = 'Nový autor';
    private const string ANNOTATION = 'Nový anotace';
    private const string CONTENT = 'Nový obsah';

    public function testPostList(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::ADMIN_EMAIL]);
        /** @var User|UserInterface $testUser */
        $client->loginUser($testUser);

        $client->request('GET', '/admin/app/post/list');
        $this->assertSelectorTextContains('li.active', 'Příspěvky');
        $this->assertAnySelectorTextContains('td', 'Zápasil těžce se');
        $this->assertAnySelectorTextContains('td', 'nevis-ze-jsme-byvali-suvereny-ach-ty-nevis');
        $this->assertAnySelectorTextContains('td', 'paul-s-kosem-na-lokti');

        $this->assertAnySelectorTextContains('td .btn', 'Odstranit');
        $this->assertAnySelectorTextContains('td .btn', 'Upravit');
        $this->assertAnySelectorTextContains('td .btn', 'Komentáře');

        $this->assertAnySelectorTextContains('div.pull-right', '4 záznamy');
    }

    public function testEditPost(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['email' => TestFixtures::ADMIN_EMAIL]);
        /** @var User|UserInterface $testUser */
        $client->loginUser($testUser);

        $client->request('GET', '/admin/app/post/list');
        $crawler = $client->clickLink('Upravit');

        $this->assertSelectorTextContains('.navbar-header', 'Nevíš nikdy nic');

        $form = $crawler->selectButton('Aktualizovat')->form();
        $sonataPrefix = SonataFormHelper::getFormPrefix($form);
        $form[$sonataPrefix . '[title]'] = self::TITLE;
        $form[$sonataPrefix . '[author]'] = self::AUTHOR;
        $form[$sonataPrefix . '[annotation]'] = self::ANNOTATION;
        $form[$sonataPrefix . '[content]'] = self::CONTENT;
        $client->submit($form);

        $client->request('GET', '/admin/app/post/list');
        $this->assertAnySelectorTextContains('td', self::TITLE);

        $client->request('GET', '/');
        $this->assertAnySelectorTextContains('h2', self::TITLE);
        $this->assertAnySelectorTextContains('span.author', self::AUTHOR);
        $this->assertAnySelectorTextContains('p.annotation', self::ANNOTATION);
        $this->assertAnySelectorTextContains('span.comments-count', '5 komentářů');

        $client->clickLink('Celý příspěvek');
        $this->assertAnySelectorTextContains('section.article-content', self::CONTENT);
    }
}
