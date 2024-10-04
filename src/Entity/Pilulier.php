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

    #[ORM\OneToMany(mappedBy: 'pilulier', targetEntity: Notification::class)]
    private Collection $notification;

    #[ORM\OneToMany(mappedBy: 'pilulier', targetEntity: Ordonnance::class)]
    private Collection $ordonnance;

    public function __construct()
    {
        $this->notification = new ArrayCollection();
        $this->ordonnance = new ArrayCollection();
        $this->activationBoutonUrgence = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    // Functions to manage notifications and ordonnances omitted for brevity
    // TODO: Add getters and setters for the notification and ordonnance properties
}