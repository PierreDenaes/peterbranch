<?php

namespace App\Controller;

use App\Repository\PostCommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, PostCommentRepository $postCommentRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'comments' => $postCommentRepository->findAllWithProfil(),
            'totals' => $postRepository->findAllSumOfComment(),
            'postsWithSumOfLike' => $postRepository->findAllWithSumOfLike(),
        ]);
       
    }
}
