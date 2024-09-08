<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testHomepage(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Příspěvky');
        $this->assertSelectorTextSame('h2', 'Nevíš nikdy nic');
        /** @noinspection CssInvalidPseudoSelector */
        $this->assertCount(1, $crawler->filter('h2:last-of-type:contains("Paul s košem na lokti,.")'));
        $this->assertSelectorCount(4, 'h2');

        $this->assertAnySelectorTextContains('span.author', 'RNDr. Vítězslav Machálek');
        $this->assertAnySelectorTextContains('p.annotation', 'zamračí se, odvrátí se');
        $this->assertAnySelectorTextContains('span.comments-count', '5 komentářů');
        $this->assertAnySelectorTextContains('p', 'Publikováno: 18.8.1997 12:10:02');
        $this->assertAnySelectorTextContains('a', 'Celý příspěvek');
        $this->assertGreaterThan(
            0,
            $crawler->filter('a[href="/post/nevis-ze-jsme-byvali-suvereny-ach-ty-nevis"]')->count()
        );
        $this->assertAnySelectorTextContains('a', 'Admin login');
    }

    public function testBrowseFromHptoPost(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $client->clickLink('Celý příspěvek');
        $this->assertSelectorTextContains('h1', 'Nevíš nikdy nic');
    }

    public function testPostPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/post/zapasil-tezce-se');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Zápasil těžce');
        $this->assertAnySelectorTextContains('span.author', 'René Albrecht');
        $this->assertAnySelectorTextContains('p', 'Publikováno: 18.4.2008 17:12:08');
        $this->assertAnySelectorTextContains(
            'section.article-content',
            'Zaváhal ještě u dveří, za nimiž nechal Anči.'
        );

        $this->assertAnySelectorTextContains('h2', 'Komentáře');
        $this->assertSelectorCount(5, 'article h3');

        $this->assertAnySelectorTextContains('h3', '1 Prokop a loudal se zpátky');
        $this->assertAnySelectorTextContains('span.author', '1 Miluše Jánská');
        $this->assertAnySelectorTextContains('p', '1 Hovor se stočil jako unavený pes a patrně usnul');
    }

    public function testPostComment(): void
    {
        $client = static::createClient();

        $client->request('GET', '/post/zapasil-tezce-se');

        $client->submitForm('Odeslat', [
            'comment[title]' => 'Nějaký nadpis komentáře',
            'comment[author]' => 'Třeba já',
            'comment[content]' => 'Lituji, ale k tomuto tématu nemám opravdu co říci.',
        ]);

        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $this->assertAnySelectorTextContains('h1', 'Děkujeme za komentář');

        $client->request('GET', '/post/zapasil-tezce-se');
        $this->assertAnySelectorTextContains('span.author', 'Třeba já');

    }
}
