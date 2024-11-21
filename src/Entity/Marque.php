<?php

namespace App\Entity;

use App\Entity\Marque;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomM = null;

    #[ORM\Column(length: 255)]
    private ?string $CreateurM = null;

    #[ORM\Column(length: 3000)]
    private ?string $HistoireM = null;

    #[ORM\Column(length: 255)]
    private ?string $RepresentantM = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Defile::class)]
    private Collection $defiles;

    public function __construct()
    {
        $this->defiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomM(): ?string
    {
        return $this->nomM;
    }

    public function setNomM(string $nomM): static
    {
        $this->nomM = $nomM;

        return $this;
    }

    public function getCreateurM(): ?string
    {
        return $this->CreateurM;
    }

    public function setCreateurM(string $CreateurM): static
    {
        $this->CreateurM = $CreateurM;

        return $this;
    }

    public function getHistoireM(): ?string
    {
        return $this->HistoireM;
    }

    public function setHistoireM(string $HistoireM): static
    {
        $this->HistoireM = $HistoireM;

        return $this;
    }

    public function getRepresentantM(): ?string
    {
        return $this->RepresentantM;
    }

    public function setRepresentantM(string $RepresentantM): static
    {
        $this->RepresentantM = $RepresentantM;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

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
            $defile->setMarque($this);
        }

        return $this;
    }

    public function removeDefile(Defile $defile): static
    {
        if ($this->defiles->removeElement($defile)) {
            // set the owning side to null (unless already changed)
            if ($defile->getMarque() === $this) {
                $defile->setMarque(null);
            }
        }

        return $this;
    }
}
