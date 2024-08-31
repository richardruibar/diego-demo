<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private const NUMBER_OF_POSTS = 5;

    private const NUMBER_OF_COMMENTS_MIN = 0;

    private const NUMBER_OF_COMMENTS_MAX = 20;

    private Generator $faker;

    public function __construct() {
        $this->faker = Factory::create('cs_CZ');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < self::NUMBER_OF_POSTS; ++$i) {
            $post = $this->createPost();
            $manager->persist($post);
            $this->addComments($manager, $post);
        }

        $manager->flush();
    }

    private function createPost(): Post
    {
        $post = new Post();
        $post
            ->setAuthor($this->faker->name)
            ->setTitle($this->faker->realText(rand(10,50)))
            ->setAnnotation($this->faker->realText(rand(150,255)))
            ->setContent($this->faker->realText(rand(1000,2000)))
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTime))
        ;

        return $post;
    }

    private function addComments(ObjectManager $manager, Post $post)
    {
        $numberOfComments = rand(self::NUMBER_OF_COMMENTS_MIN, self::NUMBER_OF_COMMENTS_MAX);

        for ($i=0; $i < $numberOfComments; ++$i) {
            $comment = $this->createComment($post);
            $manager->persist($comment);
            $post->addComment($comment);

            if (rand(0,10) < 1) {
                $deleted = new \DateTimeImmutable('yesterday');
                $comment->setDeletedAt($deleted);
            }
        }
    }

    private function createComment(Post $post): Comment
    {
        $comment = new Comment();
        $comment
            ->setTitle($this->faker->realText(rand(10,50)))
            ->setAuthor($this->faker->name)
            ->setContent($this->faker->realText(rand(100,2000)))
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTime))
        ;

        return $comment;
    }
}
