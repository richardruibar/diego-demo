<?php

namespace App\Tests\Admin;

use App\DataFixtures\TestFixtures;
use App\Repository\UserRepository;
use App\Tests\Helper\SonataFormHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{
    private const TITLE = 'Nový titulek';
    private const AUTHOR = 'Nový autor';
    private const ANNOTATION = 'Nový anotace';
    private const CONTENT = 'Nový obsah';

    public function testPostList()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(TestFixtures::ADMIN_EMAIL);
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

    public function testEditPost()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(TestFixtures::ADMIN_EMAIL);
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
