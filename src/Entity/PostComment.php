<?php

namespace App\Entity;

use App\Repository\PostCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCommentRepository::class)]
class PostComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profil $idProfil = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $idPost = null;

    #[ORM\OneToMany(mappedBy: 'idComment', targetEntity: PostCommentLike::class, orphanRemoval: true)]
    private Collection $postCommentLikes;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->postCommentLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getIdPost(): ?Post
    {
        return $this->idPost;
    }

    public function setIdPost(?Post $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * @return Collection<int, PostCommentLike>
     */
    public function getPostCommentLikes(): Collection
    {
        return $this->postCommentLikes;
    }

    public function addPostCommentLike(PostCommentLike $postCommentLike): self
    {
        if (!$this->postCommentLikes->contains($postCommentLike)) {
            $this->postCommentLikes->add($postCommentLike);
            $postCommentLike->setIdComment($this);
        }

        return $this;
    }

    public function removePostCommentLike(PostCommentLike $postCommentLike): self
    {
        if ($this->postCommentLikes->removeElement($postCommentLike)) {
            // set the owning side to null (unless already changed)
            if ($postCommentLike->getIdComment() === $this) {
                $postCommentLike->setIdComment(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
