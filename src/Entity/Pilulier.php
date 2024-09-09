<?php

namespace App\Entity;

use App\Repository\PilulierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PilulierRepository::class)]
class Pilulier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $activationBoutonUrgence = null;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'pilulier')]
    private Collection $notification;

    /**
     * @var Collection<int, Ordonnance>
     */
    #[ORM\OneToMany(targetEntity: Ordonnance::class, mappedBy: 'pilulier')]
    private Collection $ordonnance;

    public function __construct()
    {
        $this->notification = new ArrayCollection();
        $this->ordonnance = new ArrayCollection();
    }

    public function getIdPilulier(): ?int
    {
        return $this->idPilulier;
    }

    public function setIdPilulier(int $id): static
    {
        $this->idPilulier = $idPilulier;

        return $this;
    }

    public function isActivationBoutonUrgence(): ?bool
    {
        return $this->activationBoutonUrgence;
    }

    public function setActivationBoutonUrgence(bool $activationBoutonUrgence): static
    {
        $this->activationBoutonUrgence = $activationBoutonUrgence;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotification(): Collection
    {
        return $this->notification;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notification->contains($notification)) {
            $this->notification->add($notification);
            $notification->setPilulier($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notification->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getPilulier() === $this) {
                $notification->setPilulier(null);
            }
        }

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
            $ordonnance->setPilulier($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): static
    {
        if ($this->ordonnance->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getPilulier() === $this) {
                $ordonnance->setPilulier(null);
            }
        }

        return $this;
    }
}
