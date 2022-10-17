<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\PostComment;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Story;
use App\Entity\Profil;
use App\Entity\PostLike;
use App\Entity\StoryLike;
use App\Entity\PostCommentLike;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        ini_set("memory_limit", "1024M"); 
        for($i = 0; $i <= 5; $i++){
            $arr = array( "Particuliers" => "Particuliers", "Formateur" => "Formateur", "Entreprise" => "Entreprise", "Autre organisation" => "Autre organisation" );
            $user = new User();
            $user->setEmail($this->faker->email)
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'azerty'))
            ->setName($this->faker->lastName)
            ->setFirstName($this->faker->firstName)
            ->setIsVerified(1)
            ->setStatus(array_rand($arr));
            $manager->persist($user);
        }
        $manager->flush();
        $users = $manager->getRepository(User::class)->findAll();
        foreach($users as $user){
            $profil = new Profil();
            $profil->setUser($user)
            ->setFirstname($user->getName())
            ->setLastname($user->getFirstName())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setAddress($this->faker->address)
            ->setZipCode($this->faker->postcode)
            ->setCountry($this->faker->country)
            ->setStatus($user->getStatus())
            ->setSiret($this->faker->siret)
                ->setIsActive(1)
                ->setImageName('web-search-vector-icon-png-253149-6331a52e33534282542452.jpeg')

        ;
        $manager->persist($profil);
        }
        $manager->flush();

        $profils = $manager->getRepository(Profil::class)->findAll();

        for($i = 0; $i <= 5; $i++){
            $arrImage = array("pexel1.jpg" => "pexel1.jpg", "pexel2.jpg" => "pexel2.jpg", "pexel3.jpg" => "pexel3
            .jpg", "pexel4.jpg" => "pexel4.jpg", "pexel5.jpg" => "pexel5.jpg", "pexel6.jpg" => "pexel6.jpg", "pexel7.jpg" => "pexel7.jpg", "pexel8.jpg" => "pexel8.jpg", "pexel9.jpg" => "pexel9.jpg", "pexel10.jpg" => "pexel10.jpg");
            foreach($profils as $profilUnique){
                $post = new Post();
                $post->setIdProfil($profilUnique)
                ->setTitle($this->faker->sentence(4))
                ->setContent($this->faker->paragraph)
                ->setCreatedAt($this->faker->dateTimeBetween('-6 months'))
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setImageName(array_rand($arrImage));
                $manager->persist($post);
            }
        }
        $manager->flush();

        $posts = $manager->getRepository(Post::class)->findAll();
        for ($i = 0; $i <= 5; $i++) {
            foreach($profils as $profilUnique){
                foreach ($posts as $postUnique) {
                    $postlike = new PostLike();
                    $postlike->setIdProfil($profilUnique)
                        ->setIdPost($postUnique)
                        ->setIsActive(1);
                    $manager->persist($postlike);
                }
            }
        }

        $manager->flush();

        for ($i = 0; $i <= 2; $i++) {
            foreach($profils as $profilUnique){
                foreach ($posts as $postUnique) {
                    $postComment = new PostComment();
                    $postComment->setContent($this->faker->paragraph)
                    ->setIdProfil($profilUnique)
                    ->setIdPost($postUnique)
                    ->setCreatedAt($this->faker->dateTime);

                    $manager->persist($postComment);
                }
            }
        }
        $manager->flush();

        $comments = $manager->getRepository(PostComment::class)->findAll();
        for ($i = 0; $i <= 5; $i++) {
            foreach($profils as $profilUnique){
                foreach ($comments as $comment) {
                    $postCommentLike = new PostCommentLike();
                    $postCommentLike->setIsActive(1)
                    ->setIdProfil($profilUnique)
                    ->setIdComment($comment);
                    $manager->persist($postCommentLike);
                }
            }
        }
        $manager->flush();

        for($i = 0; $i <= 10; $i++){
            foreach($profils as $profilUnique){
                $story = new Story();
                $story->setIdProfil($profilUnique)
                ->setTitle($this->faker->sentence(4))
                ->setContent($this->faker->sentence(4))
                ->setIsActive(1)
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setImageName('postArticle.jpeg');
                $manager->persist($story);
            }
        }
        $manager->flush();

        $stories = $manager->getRepository(Story::class)->findAll();
        for ($i = 0; $i <= 5; $i++) {
            foreach($profils as $profilUnique){
                foreach ($stories as $storyUnique) {
                    $storylike = new StoryLike();
                    $storylike->setIdProfil($profilUnique)
                        ->setIdStory($storyUnique)
                        ->setIsActive(1);
                    $manager->persist($storylike);
                }
            }
        }
        $manager->flush();
    }
}
