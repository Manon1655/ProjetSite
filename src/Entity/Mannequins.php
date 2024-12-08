<?php

namespace App\Entity;

use App\Entity\ImageMannequin;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MannequinsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MannequinsRepository::class)]
class Mannequins
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $Nationalite = null;

    #[ORM\ManyToMany(targetEntity: Defile::class, mappedBy: 'mannequin')]
    private Collection $defiles;

    #[ORM\Column(length: 1000)]
    private ?string $biographieM = null;

    #[ORM\OneToMany(mappedBy: 'mannequinId', targetEntity: ImageMannequin::class)]
    private Collection $imageMannequins;

    public function __construct()
    {
        $this->defiles = new ArrayCollection();
        $this->imageMannequins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, ImageMannequin>
     */
    public function getImageMannequins(): Collection
    {
        return $this->imageMannequins;
    }

    public function addImageMannequin(ImageMannequin $imageMannequin): static
    {
        if (!$this->imageMannequins->contains($imageMannequin)) {
            $this->imageMannequins->add($imageMannequin);
            $imageMannequin->setMannequinId($this);
        }

        return $this;
    }

    public function removeImageMannequin(ImageMannequin $imageMannequin): static
    {
        if ($this->imageMannequins->removeElement($imageMannequin)) {
            // set the owning side to null (unless already changed)
            if ($imageMannequin->getMannequinId() === $this) {
                $imageMannequin->setMannequinId(null);
            }
        }

        return $this;
    }
}
