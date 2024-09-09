<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idNotification = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'notification')]
    private ?Pilulier $pilulier = null;

    /**
     * @var Collection<int, Aidant>
     */
    #[ORM\ManyToMany(targetEntity: Aidant::class, inversedBy: 'notifications')]
    private Collection $aidant;

    public function __construct()
    {
        $this->aidant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdNotification(): ?int
    {
        return $this->idNotification;
    }

    public function setIdNotification(int $idNotification): static
    {
        $this->idNotification = $idNotification;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

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
     * @return Collection<int, Aidant>
     */
    public function getAidant(): Collection
    {
        return $this->aidant;
    }

    public function addAidant(Aidant $aidant): static
    {
        if (!$this->aidant->contains($aidant)) {
            $this->aidant->add($aidant);
        }

        return $this;
    }

    public function removeAidant(Aidant $aidant): static
    {
        $this->aidant->removeElement($aidant);

        return $this;
    }
}
