<?php

namespace App\Entity;

use App\Repository\StoryLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoryLikeRepository::class)]
class StoryLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'storyLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Story $idStory = null;

    #[ORM\ManyToOne(inversedBy: 'storyLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profil $idProfil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIdStory(): ?Story
    {
        return $this->idStory;
    }

    public function setIdStory(?Story $idStory): self
    {
        $this->idStory = $idStory;

        return $this;
    }

    public function getIdProfil(): ?Profil
    {
        return $this->idProfil;
    }

    public function setIdProfil(?Profil $idProfil): self
    {
        $this->idProfil = $idProfil;

        return $this;
    }
}
