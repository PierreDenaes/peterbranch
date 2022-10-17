<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
#[Vich\Uploadable] 


class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'avatar', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siret = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: PostComment::class, orphanRemoval: true)]
    private Collection $postComments;

    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: PostLike::class, orphanRemoval: true)]
    private Collection $postLikes;


    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: PostCommentLike::class, orphanRemoval: true)]
    private Collection $postCommentLikes;

    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: Story::class, orphanRemoval: true)]
    private Collection $stories;

    #[ORM\OneToMany(mappedBy: 'idProfil', targetEntity: StoryLike::class, orphanRemoval: true)]
    private Collection $storyLikes;

    #[ORM\Column]
    private ?bool $isActive = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->postComments = new ArrayCollection();
        $this->postLikes = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->postCommentLikes = new ArrayCollection();
        $this->storiess = new ArrayCollection();
        $this->storyLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->firstname. ' ' .$this->lastname.' '.$this->imageName. ' ' .$this->address.' '.$this->zipCode. ' ' .$this->country.' '.$this->siret;
    }
      /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;


        return $this;
    }


    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setIdProfil($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getIdProfil() === $this) {
                $post->setIdProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostComment>
     */
    public function getPostComments(): Collection
    {
        return $this->postComments;
    }

    public function addPostComment(PostComment $postComment): self
    {
        if (!$this->postComments->contains($postComment)) {
            $this->postComments->add($postComment);
            $postComment->setIdProfil($this);
        }

        return $this;
    }

    public function removePostComment(PostComment $postComment): self
    {
        if ($this->postComments->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getIdProfil() === $this) {
                $postComment->setIdProfil(null);
            }
        }


        return $this;
    }


    /**
     * @return Collection<int, PostLike>
     */
    public function getPostLikes(): Collection
    {
        return $this->postLikes;
    }

    public function addPostLike(PostLike $postLike): self
    {
        if (!$this->postLikes->contains($postLike)) {
            $this->postLikes->add($postLike);
            $postLike->setIdProfil($this);
        }

        return $this;
    }

    public function removePostLike(PostLike $postLike): self
    {
        if ($this->postLikes->removeElement($postLike)) {
            // set the owning side to null (unless already changed)
            if ($postLike->getIdProfil() === $this) {
                $postLike->setIdProfil(null);
            }
        }


        return $this;
    }


    /**
     * @return Collection<int, Story>
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Story $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories->add($story);
            $story->setIdProfil($this);
        }

        return $this;
    }

    public function removeStory(Story $story): self
    {
        if ($this->stories->removeElement($story)) {
            // set the owning side to null (unless already changed)
            if ($story->getIdProfil() === $this) {
                $story->setIdProfil(null);
            }
        }


        return $this;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
            $postCommentLike->setIdProfil($this);
        }

        return $this;
    }

    public function removePostCommentLike(PostCommentLike $postCommentLike): self
    {
        if ($this->postCommentLikes->removeElement($postCommentLike)) {
            // set the owning side to null (unless already changed)
            if ($postCommentLike->getIdProfil() === $this) {
                $postCommentLike->setIdProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Story>
     */
    public function getStoriess(): Collection
    {
        return $this->storiess;
    }

    public function addStoriess(Story $storiess): self
    {
        if (!$this->storiess->contains($storiess)) {
            $this->storiess->add($storiess);
            $storiess->setIdProfil($this);
        }

        return $this;
    }

    public function removeStoriess(Story $storiess): self
    {
        if ($this->storiess->removeElement($storiess)) {
            // set the owning side to null (unless already changed)
            if ($storiess->getIdProfil() === $this) {
                $storiess->setIdProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StoryLike>
     */
    public function getStoryLikes(): Collection
    {
        return $this->storyLikes;
    }

    public function addStoryLike(StoryLike $storyLike): self
    {
        if (!$this->storyLikes->contains($storyLike)) {
            $this->storyLikes->add($storyLike);
            $storyLike->setIdProfil($this);
        }

        return $this;
    }

    public function removeStoryLike(StoryLike $storyLike): self
    {
        if ($this->storyLikes->removeElement($storyLike)) {
            // set the owning side to null (unless already changed)
            if ($storyLike->getIdProfil() === $this) {
                $storyLike->setIdProfil(null);
            }
        }

        return $this;
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

    /**
     * Get the value of isActive
     */ 
    public function getIsActive()
    {
        return $this->isActive;
    }
}
