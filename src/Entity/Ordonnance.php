<?php

namespace App\Entity;

use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idOrdonnance = null;

    #[ORM\Column(length: 255)]
    private ?string $posologie = null;

    #[ORM\Column(length: 255)]
    private ?string $frequence = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnance')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'ordonnance')]
    private ?Pilulier $pilulier = null;

    /**
     * @var Collection<int, Medicament>
     */
    #[ORM\OneToMany(targetEntity: Medicament::class, mappedBy: 'ordonnance')]
    private Collection $medicament;

    public function __construct()
    {
        $this->medicament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrdonnance(): ?int
    {
        return $this->idOrdonnance;
    }

    public function setIdOrdonnance(int $idOrdonnance): static
    {
        $this->idOrdonnance = $idOrdonnance;

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

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): static
    {
        $this->frequence = $frequence;

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

    public function getPilulier(): ?Pilulier
    {
        return $this->pilulier;
    }

    public function setPilulier(?Pilulier $pilulier): static
    {
        $this->pilulier = $pilulier;

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMedicament(): Collection
    {
        return $this->medicament;
    }

    public function addMedicament(Medicament $medicament): static
    {
        if (!$this->medicament->contains($medicament)) {
            $this->medicament->add($medicament);
            $medicament->setOrdonnance($this);
        }

        return $this;
    }

    public function removeMedicament(Medicament $medicament): static
    {
        if ($this->medicament->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getOrdonnance() === $this) {
                $medicament->setOrdonnance(null);
            }
        }

        return $this;
    }
}
