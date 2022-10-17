<?php

namespace App\Entity;

use App\Repository\PostCommentLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCommentLikeRepository::class)]
class PostCommentLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'postCommentLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostComment $idComment = null;

    #[ORM\ManyToOne(inversedBy: 'postCommentLikes')]
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

    public function getIdComment(): ?PostComment
    {
        return $this->idComment;
    }

    public function setIdComment(?PostComment $idComment): self
    {
        $this->idComment = $idComment;

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
