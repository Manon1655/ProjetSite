<?php

namespace App\Entity;

use App\Repository\DefileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DefileRepository::class)]
class Defile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomD = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToOne(inversedBy: 'defiles')]
    private ?Marque $marque = null;

    #[ORM\OneToMany(mappedBy: 'defile', targetEntity: Blog::class)]
    private Collection $blogs;

    #[ORM\ManyToMany(targetEntity: Mannequins::class, inversedBy: 'defiles')]
    private Collection $mannequin;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->mannequin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomD(): ?string
    {
        return $this->NomD;
    }

    public function setNomD(string $NomD): static
    {
        $this->NomD = $NomD;

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

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): static
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs->add($blog);
            $blog->setDefile($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): static
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getDefile() === $this) {
                $blog->setDefile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mannequins>
     */
    public function getMannequin(): Collection
    {
        return $this->mannequin;
    }

    public function addMannequin(Mannequins $mannequin): static
    {
        if (!$this->mannequin->contains($mannequin)) {
            $this->mannequin->add($mannequin);
        }

        return $this;
    }

    public function removeMannequin(Mannequins $mannequin): static
    {
        $this->mannequin->removeElement($mannequin);

        return $this;
    }
}
