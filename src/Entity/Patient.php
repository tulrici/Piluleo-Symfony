<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient extends Utilisateur
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $HistoriqueMedical = null;

    #[ORM\Column(nullable: true)]
    private ?array $allergies = null;

    #[ORM\Column(length: 255)]
    private ?string $adressePostale = null;

    #[ORM\Column(length: 255)]
    private ?string $CodePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\ManyToOne]
    private ?Pilulier $pilulier = null;

    /**
     * @var Collection<int, Ordonnance>
     */
    #[ORM\OneToMany(targetEntity: Ordonnance::class, mappedBy: 'patient')]
    private Collection $ordonnance;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\OneToMany(targetEntity: Traitement::class, mappedBy: 'patient')]
    private Collection $traitement;

    public function __construct()
    {
        parent::__construct(); // Ajout de l'appel au constructeur parent
        $this->ordonnance = new ArrayCollection();
        $this->traitement = new ArrayCollection();
    }

    public function getRole(): string
    {
        return 'ROLE_PATIENT';
    }

    public function getHistoriqueMedical(): ?string
    {
        return $this->HistoriqueMedical;
    }

    public function setHistoriqueMedical(string $HistoriqueMedical): static
    {
        $this->HistoriqueMedical = $HistoriqueMedical;
        return $this;
    }

    public function getAllergies(): ?array
    {
        return $this->allergies;
    }

    public function setAllergies(?array $allergies): static
    {
        $this->allergies = $allergies;
        return $this;
    }

    public function getAdressePostale(): ?string
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(string $adressePostale): static
    {
        $this->adressePostale = $adressePostale;
        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): static
    {
        $this->CodePostal = $CodePostal;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;
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
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnance(): Collection
    {
        return $this->ordonnance;
    }

    public function addOrdonnance(Ordonnance $ordonnance): static
    {
        if (!$this->ordonnance->contains($ordonnance)) {
            $this->ordonnance->add($ordonnance);
            $ordonnance->setPatient($this);
        }
        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): static
    {
        if ($this->ordonnance->removeElement($ordonnance)) {
            if ($ordonnance->getPatient() === $this) {
                $ordonnance->setPatient(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitement(): Collection
    {
        return $this->traitement;
    }

    public function addTraitement(Traitement $traitement): static
    {
        if (!$this->traitement->contains($traitement)) {
            $this->traitement->add($traitement);
            $traitement->setPatient($this);
        }
        return $this;
    }

    public function removeTraitement(Traitement $traitement): static
    {
        if ($this->traitement->removeElement($traitement)) {
            if ($traitement->getPatient() === $this) {
                $traitement->setPatient(null);
            }
        }
        return $this;
    }
}
