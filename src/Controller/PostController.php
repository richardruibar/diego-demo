<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function homePage(EntityManagerInterface $entityManager): Response
    {
        return $this->render('index.html.twig', [
            'posts' => $entityManager->getRepository(Post::class)->fetchAll(),
        ]);
    }
}
