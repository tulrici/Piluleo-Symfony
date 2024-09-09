<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idMedicament = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $posologieOrdonnance = null;

    #[ORM\ManyToOne(inversedBy: 'medicament')]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMedicament(): ?int
    {
        return $this->idMedicament;
    }

    public function setIdMedicament(int $idMedicament): static
    {
        $this->idMedicament = $idMedicament;

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

    public function getPosologieOrdonnance(): ?string
    {
        return $this->posologieOrdonnance;
    }

    public function setPosologieOrdonnance(string $posologieOrdonnance): static
    {
        $this->posologieOrdonnance = $posologieOrdonnance;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): static
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }
}
