<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Profil;
use App\Form\PostType;
use App\Entity\PostLike;
use App\Form\ProfilType;
use App\Form\PostLikeType;
use App\Entity\PostComment;
use App\Form\PostCommentType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/profil')]

class ProfilController extends AbstractController
{
    #[Route('/', name: 'app_profil')]
    public function index(EntityManagerInterface $entityManager, Request $request, ProfilRepository
    $profilRepository, UserRepository $userRepository, PostRepository $postRepository, PostCommentRepository
    $postCommentRepository, PostLikeRepository $postLikeRepository):
    Response
    {
        $user = $this->getUser();
        $userProfil = $userRepository->findCurrentUser($user);

        $profil = new Profil();
        $profil->setUser($userProfil);
        $profil->setLastname($userProfil->getName());
        $profil->setFirstname($userProfil->getFirstName());
        $profil->setStatus($userProfil->getStatus());
        $profil->setIsActive(1);
        

        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($profil);
            $entityManager->flush();


            return $this->redirectToRoute('app_profil');
        }
       
        $profilComplet = $profilRepository->findByUserProfil($user);
        
        return $this->render('profil/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'comments' => $postCommentRepository->findAll(),
            'postLike' => $postLikeRepository->findAll(),
            'profilComplet' => $profilComplet,
            'profil' => $form->createView(),
            'user' => $user,   
        ]);
    }
    #[Route('/post', name: 'app_post_index', methods: ['GET'])]
    public function indexPost(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/post/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function newPost(Request $request, PostRepository $postRepository, ProfilRepository $profilRepository): Response
    {
        $user = $this->getUser();
        $profilComplet = $profilRepository->findByUserProfil($user);

        $post = new Post();
        $post->setIdProfil($profilComplet);
        $post->setCreatedAt(new \DateTimeImmutable());
        $post->setIsActive(0);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/post/{id}', name: 'app_post_show', methods: ['GET'])]
    public function showPost(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
   

    #[Route('/post/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('id', options: ['mapping' => ['id' => 'id']])]
    public function editPost(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/post/{id}', name: 'app_post_delete', methods: ['POST'])]
    #[ParamConverter('id', options: ['mapping' => ['id' => 'id']])]
    public function deletePost(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/comment', name: 'app_post_comment_index', methods: ['GET'])]
    public function indexComment(PostCommentRepository $postCommentRepository): Response
    {
        return $this->render('post_comment/index.html.twig', [
            'post_comments' => $postCommentRepository->findAll(),
        ]);
    }

    #[Route('/comment/new', name: 'app_post_comment_new', methods: ['GET', 'POST'])]
    public function newComment(Request $request, PostCommentRepository $postCommentRepository, ProfilRepository $profilRepository, PostRepository $postRepository): Response
    {
        $idPost= $request->get('idPost');
        $post = $postRepository->find($idPost);
        $user = $this->getUser();
        $profilComplet = $profilRepository->findByUserProfil($user);
        $postComment = new PostComment();
        $postComment->setIdProfil($profilComplet);
        $postComment->setIdPost($post);
        $postComment->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCommentRepository->add($postComment, true);

            return $this->redirectToRoute('app_post_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_comment/new.html.twig', [
            'post_comment' => $postComment,
            'form' => $form,
        ]);
    }

    #[Route('/comment/{id}', name: 'app_post_comment_show', methods: ['GET'])]
    public function showComment(PostComment $postComment): Response
    {
        return $this->render('post_comment/show.html.twig', [
            'post_comment' => $postComment,
        ]);
    }

    #[Route('/comment/{id}/edit', name: 'app_post_comment_edit', methods: ['GET', 'POST'])]
    public function editComment(Request $request, PostComment $postComment, PostCommentRepository $postCommentRepository): Response
    {
        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCommentRepository->add($postComment, true);

            return $this->redirectToRoute('app_post_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_comment/edit.html.twig', [
            'post_comment' => $postComment,
            'form' => $form,
        ]);
    }

    #[Route('/comment/{id}', name: 'app_post_comment_delete', methods: ['POST'])]
    public function deleteComment(Request $request, PostComment $postComment, PostCommentRepository $postCommentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postComment->getId(), $request->request->get('_token'))) {
            $postCommentRepository->remove($postComment, true);
        }

        return $this->redirectToRoute('app_post_comment_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/like', name: 'app_post_like_index', methods: ['GET'])]
    public function indexLike(PostLikeRepository $postLikeRepository): Response
    {
        return $this->render('post_like/index.html.twig', [
            'post_likes' => $postLikeRepository->findAll(),
        ]);
    }

    #[Route('/like/new', name: 'app_post_like_new', methods: ['GET', 'POST'])]
    public function newLike(Request $request, PostLikeRepository $postLikeRepository, ProfilRepository $profilRepository, PostRepository $postRepository): Response
    {
        $idPost= $request->get('idPost');
        $post = $postRepository->find($idPost);
        $user = $this->getUser();
        $profilComplet = $profilRepository->findByUserProfil($user);
        $postLike = new PostLike();
        $postLike->setIdProfil($profilComplet);
        $postLike->setIdPost($post);
        $postLike->setIsActive(1);
        $form = $this->createForm(PostLikeType::class, $postLike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postLikeRepository->add($postLike, true);

            return $this->redirectToRoute('app_post_like_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_like/new.html.twig', [
            'post_like' => $postLike,
            'form' => $form,
        ]);
    }

    #[Route('/like/{id}', name: 'app_post_like_show', methods: ['GET'])]
    public function showLike(PostLike $postLike): Response
    {
        return $this->render('post_like/show.html.twig', [
            'post_like' => $postLike,
        ]);
    }

    #[Route('/like/{id}/edit', name: 'app_post_like_edit', methods: ['GET', 'POST'])]
    public function editLike(Request $request, PostLike $postLike, PostLikeRepository $postLikeRepository): Response
    {
        $form = $this->createForm(PostLikeType::class, $postLike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postLikeRepository->add($postLike, true);

            return $this->redirectToRoute('app_post_like_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_like/edit.html.twig', [
            'post_like' => $postLike,
            'form' => $form,
        ]);
    }

    #[Route('/like/{id}', name: 'app_post_like_delete', methods: ['POST'])]
    public function deleteLike(Request $request, PostLike $postLike, PostLikeRepository $postLikeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postLike->getId(), $request->request->get('_token'))) {
            $postLikeRepository->remove($postLike, true);
        }

        return $this->redirectToRoute('app_post_like_index', [], Response::HTTP_SEE_OTHER);
    }
}
