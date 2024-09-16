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

    // API Communication Methods using cURL directly

    public function open(): void
    {
        $url = 'http://10.20.0.54:5000/pillbox/open';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'An error occurred while trying to open the pilulier: ' . curl_error($ch);
        } else {
            if ($http_code === 200) {
                echo "Pilulier opened successfully.";
            } else {
                echo "Failed to open the pilulier. Status code: " . $http_code;
            }
        }

        curl_close($ch);
    }

    public function close(): void
    {
        $url = 'http://10.20.0.54:5000/pillbox/close';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'An error occurred while trying to close the pilulier: ' . curl_error($ch);
        } else {
            if ($http_code === 200) {
                echo "Pilulier closed successfully.";
            } else {
                echo "Failed to close the pilulier. Status code: " . $http_code;
            }
        }

        curl_close($ch);
    }

    public function power(): void
    {
        $url = 'http://10.20.0.54:5000/pillbox/power';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'An error occurred while trying to toggle power: ' . curl_error($ch);
        } else {
            if ($http_code === 200) {
                echo "Pilulier power toggled successfully.";
            } else {
                echo "Failed to toggle power. Status code: " . $http_code;
            }
        }

        curl_close($ch);
    }

    public function remote(): void
    {
        $url = 'http://10.20.0.54:5000/pillbox/remote';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Optionally, set headers if needed
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'An error occurred while trying to trigger remote control: ' . curl_error($ch);
        } else {
            if ($http_code === 200) {
                echo "Pilulier remote control triggered successfully.";
            } else {
                echo "Failed to trigger remote control. Status code: " . $http_code;
            }
        }

        curl_close($ch);
    }

    public function testMotor(): void
    {
        $url = 'http://10.20.0.54:5000/pillbox/test-motor';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo 'An error occurred while trying to test the motor: ' . curl_error($ch);
        } else {
            if ($http_code === 200) {
                echo "Motor test completed successfully.";
            } else {
                echo "Failed to test motor. Status code: " . $http_code;
            }
        }

        curl_close($ch);
    }
}