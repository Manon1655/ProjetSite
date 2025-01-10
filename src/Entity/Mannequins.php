<?php

namespace App\Entity;

use App\Entity\ImageMannequin;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MannequinsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MannequinsRepository::class)]
class Mannequins
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, minMessage: "Le nom doit comporter au moins {{ limit }} caractères.")]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2, minMessage: "Le prénom doit comporter au moins {{ limit }} caractères.")]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La nationalité est obligatoire.")]
    private ?string $Nationalite = null;

    #[ORM\ManyToMany(targetEntity: Defile::class, mappedBy: 'mannequin')]
    private Collection $defiles;

    #[ORM\Column(length: 1000)]
    #[Assert\NotBlank(message: "La biographie est obligatoire.")]
    #[Assert\Length(min: 20, minMessage: "La biographie doit comporter au moins {{ limit }} caractères.")]
    private ?string $biographieM = null;

    #[ORM\Column(length: 1000)]
    private ?string $imageMannequins = null;

    // #[ORM\Column]
    // private ?\DateTimeImmutable $updatedAt = null;




    public function __construct()
    {
        $this->defiles = new ArrayCollection();
        $this->imageMannequins = new ArrayCollection();
        // $this->setUpdatedAt(new \DateTimeImmutable);
        // $this->setImageMannequins("defile-de-mode-monument-historique.jpg");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->Nom; 
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->Nationalite;
    }

    public function setNationalite(string $Nationalite): static
    {
        $this->Nationalite = $Nationalite;

        return $this;
    }

    /**
     * @return Collection<int, Defile>
     */
    public function getDefiles(): Collection
    {
        return $this->defiles;
    }

    public function addDefile(Defile $defile): static
    {
        if (!$this->defiles->contains($defile)) {
            $this->defiles->add($defile);
            $defile->addMannequin($this);
        }

        return $this;
    }

    public function removeDefile(Defile $defile): static
    {
        if ($this->defiles->removeElement($defile)) {
            $defile->removeMannequin($this);
        }

        return $this;
    }

    public function getBiographieM(): ?string
    {
        return $this->biographieM;
    }

    public function setBiographieM(string $biographieM): static
    {
        $this->biographieM = $biographieM;

        return $this;
    }

    public function getImageMannequins(): ?string
    {
        return $this->imageMannequins;
    }

    public function setImageMannequins(string $imageMannequins): static
    {
        $this->imageMannequins = $imageMannequins;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
