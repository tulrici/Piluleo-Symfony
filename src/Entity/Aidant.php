<?php

namespace App\Entity;

use App\Repository\AidantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AidantRepository::class)]
class Aidant extends Utilisateur
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialisation = null;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\ManyToMany(targetEntity: Notification::class, mappedBy: 'aidant')]
    private Collection $notifications;

    /**
     * @var Collection<int, Traitement>
     */
    #[ORM\ManyToMany(targetEntity: Traitement::class, inversedBy: 'aidants')]
    private Collection $traitement;
    
    public static function getRole(): string
    {
        return 'ROLE_AIDANT';
    }
    public function __construct()
    {
        $this->notifications = new ArrayCollection();
        $this->traitement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialisation(): ?string
    {
        return $this->specialisation;
    }

    public function setSpecialisation(?string $specialisation): static
    {
        $this->specialisation = $specialisation;

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->addAidant($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notifications->removeElement($notification)) {
            $notification->removeAidant($this);
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
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): static
    {
        $this->traitement->removeElement($traitement);

        return $this;
    }
}
