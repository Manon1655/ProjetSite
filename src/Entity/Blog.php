<?php

namespace App\Entity;


use App\Entity\Defile;
use DateTimeInterface;
use App\Entity\Commentaire;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlogRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Vous devez nommer votre article.")]
    private ?string $NomArticle = null;

    #[ORM\Column(length: 1000)]
    #[Assert\Length(min: 10, minMessage: "Le contenu doit comporter au moins {{ limit }} caractères.")]
    private ?string $Contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $Date;

    #[ORM\ManyToOne(targetEntity: Defile::class, inversedBy: 'blogs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Defile $defile = null;    

    #[ORM\Column(length: 1000)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: Commentaire::class, cascade: ['persist', 'remove'])]
    private Collection $commentaires;

    #[ORM\ManyToOne(inversedBy: 'blogs')]
    private ?User $user = null;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->NomArticle;
    }

    public function __toString(): string
    {
        return $this->NomArticle;
    }

    public function setNomArticle(string $NomArticle): static
    {
        $this->NomArticle = $NomArticle;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): static
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDefile(): ?string
    {
        return $this->defile;
    }

    public function setDefile(?Defile $defile): self
    {
        $this->defile = $defile;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setBlog($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBlog() === $this) {
                $commentaire->setBlog(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
