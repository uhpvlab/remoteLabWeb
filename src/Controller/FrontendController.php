<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'app_frontend')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendController',
        ]);
    }

    #[Route('/blog/{page}', name: 'app_blog_index', defaults: ['page' => 1])]
    public function blog(BlogPostRepository $blogPostRepository, $page): Response
    {
        $pageSize = 10;
        $records = $blogPostRepository->findAll();
//        $records = $blogPostRepository->findBy([],['updatedAt'=>'desc'], $pageSize, ($page-1)*$pageSize);
        return $this->render('frontend/blog.html.twig', [
            'posts' => $records
        ]);
    }
}
