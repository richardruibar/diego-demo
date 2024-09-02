<?php
/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 * Due to bug in PHP Storm
 * @link https://youtrack.jetbrains.com/issue/WI-71013/Multiple-definitions-exist-for-class-for-definitions-inside-if-else-statement
 */
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function fetchAll(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
