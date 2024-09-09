<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idTraitement = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $posologie = null;

    #[ORM\ManyToOne(inversedBy: 'traitement')]
    private ?Patient $patient = null;

    /**
     * @var Collection<int, Aidant>
     */
    #[ORM\ManyToMany(targetEntity: Aidant::class, mappedBy: 'traitement')]
    private Collection $aidants;

    public function __construct()
    {
        $this->aidants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTraitement(): ?int
    {
        return $this->idTraitement;
    }

    public function setIdTraitement(int $idTraitement): static
    {
        $this->idTraitement = $idTraitement;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): static
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return Collection<int, Aidant>
     */
    public function getAidants(): Collection
    {
        return $this->aidants;
    }

    public function addAidant(Aidant $aidant): static
    {
        if (!$this->aidants->contains($aidant)) {
            $this->aidants->add($aidant);
            $aidant->addTraitement($this);
        }

        return $this;
    }

    public function removeAidant(Aidant $aidant): static
    {
        if ($this->aidants->removeElement($aidant)) {
            $aidant->removeTraitement($this);
        }

        return $this;
    }
}
