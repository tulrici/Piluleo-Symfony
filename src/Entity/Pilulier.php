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

    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'pilulier')]
    private Collection $notification;

    #[ORM\OneToMany(targetEntity: Ordonnance::class, mappedBy: 'pilulier')]
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

    // API Communication Methods
    public function open(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/open';

        try {
            $response = $this->client->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                echo "Pilulier opened successfully.";
            } else {
                echo "Failed to open the pilulier. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to open the pilulier: " . $e->getMessage();
        }
    }

    public function close(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/close';

        try {
            $response = $this->client->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                echo "Pilulier closed successfully.";
            } else {
                echo "Failed to close the pilulier. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to close the pilulier: " . $e->getMessage();
        }
    }

    public function power(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/power';

        try {
            $response = $this->client->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                echo "Pilulier power toggled successfully.";
            } else {
                echo "Failed to toggle power. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to toggle power: " . $e->getMessage();
        }
    }

    public function remote(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/remote';

        try {
            $response = $this->client->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                echo "Pilulier remote control triggered successfully.";
            } else {
                echo "Failed to trigger remote control. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to trigger remote control: " . $e->getMessage();
        }
    }

    public function testMotor(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/test-motor';

        try {
            $response = $this->client->request('POST', $url);

            if ($response->getStatusCode() === 200) {
                echo "Motor test completed successfully.";
            } else {
                echo "Failed to test motor. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to test the motor: " . $e->getMessage();
        }
    }
}