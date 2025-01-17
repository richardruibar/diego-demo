<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    private const int NUMBER_OF_POSTS = 5;

    private const int NUMBER_OF_COMMENTS_MIN = 0;

    private const int NUMBER_OF_COMMENTS_MAX = 20;

    private Generator $faker;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        $this->faker = Factory::create('cs_CZ');
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUserAdmin($manager);

        for ($i = 0; $i < self::NUMBER_OF_POSTS; ++$i) {
            $post = $this->createPost();
            $manager->persist($post);
            $this->addComments($post);
        }

        $manager->flush();
    }

    private function createUserAdmin(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            plainPassword: '123456'
        );

        $user->setPassword($hashedPassword);

        $manager->persist($user);
    }

    private function createPost(): Post
    {
        $post = new Post();
        $post
            ->setAuthor($this->faker->name)
            ->setTitle($this->faker->realText(rand(10, 50)))
            ->setAnnotation($this->faker->realText(rand(150, 255)))
            ->setContent($this->faker->realText(rand(1000, 2000)))
            ->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTime)
            );

        return $post;
    }

    private function addComments(Post $post): void
    {
        $numberOfComments = rand(
            self::NUMBER_OF_COMMENTS_MIN,
            self::NUMBER_OF_COMMENTS_MAX
        );

        for ($i = 0; $i < $numberOfComments; ++$i) {
            $comment = $this->createComment();
            $post->addComment($comment);

            if (rand(0, 10) < 1) {
                $deleted = new DateTimeImmutable('yesterday');
                $comment->setDeletedAt($deleted);
            }
        }
    }

    private function createComment(): Comment
    {
        $comment = new Comment();
        $comment
            ->setTitle($this->faker->realText(rand(10, 50)))
            ->setAuthor($this->faker->name)
            ->setContent($this->faker->realText(rand(100, 2000)))
            ->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTime)
            );

        return $comment;
    }

    public static function getGroups(): array
    {
        return ['app'];
    }
}
