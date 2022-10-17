<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostCommentRepository;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, PostCommentRepository $postCommentRepository,
                          PostLikeRepository $postLikeRepository): Response
    {


        return $this->render('home/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'comments' => $postCommentRepository->findAll(),
            'postLikes' => $postLikeRepository->findAll(),
            'postLikesSum' => $postLikeRepository->findSomePostLike(),
        ]);
       
    }
}
