<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\Profil;
use App\Form\PostType;
use App\Form\ProfilType;
use App\Repository\PostCommentRepository;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'postLike' => $postLikeRepository->findSomePostLike(),
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
    public function new(Request $request, PostRepository $postRepository, ProfilRepository $profilRepository): Response
    {
        $user = $this->getUser();
        $profilComplet = $profilRepository->findByUserProfil($user);

        $post = new Post();
        $post->setIdProfil($profilComplet);
        $post->setCreatedAt(new \DateTimeImmutable());
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
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
   

    #[Route('/post/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('id', options: ['mapping' => ['id' => 'id']])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
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
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
    }
}
