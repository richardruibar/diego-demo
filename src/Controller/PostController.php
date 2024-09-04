<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/', name: 'home_page')]
    public function homePage(PostRepository $postRepository): Response
    {
        return $this->render('index.html.twig', [
            'posts' => $postRepository->fetchAll(),
        ]);
    }

    #[Route('/{slug}', name: 'post')]
    public function viewPost(Request $request, string $slug): Response
    {
        $this->entityManager->getFilters()->enable('softdeleteable');

        /** @var Post $post */
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneBy(['slug' => $slug]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $post->addComment($comment);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('thanks', ['slug' => $slug]);
        }

        return $this->render('post.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/dekujeme', name: 'thanks')]
    public function thanksForPost(string $slug): Response
    {
        /** @var Post $post */
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneBy(['slug' => $slug]);

        return $this->render('thanks.html.twig', [
            'post' => $post,
        ]);
    }
}
