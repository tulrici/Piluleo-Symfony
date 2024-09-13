<?php

namespace App\Entity;

use App\Repository\PilulierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[ORM\Entity(repositoryClass: PilulierRepository::class)]
class Pilulier
{
    private HttpClientInterface $client;

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

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->notification = new ArrayCollection();
        $this->ordonnance = new ArrayCollection();

        // Set the default value of activationBoutonUrgence to false
        $this->activationBoutonUrgence = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdPilulier(int $id): static
    {
        $this->idPilulier = $id;

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
    public function open(): void
    {
        // The URL for the Python API endpoint that will open the pill dispenser
        $url = 'http://127.0.0.1:5000/pillbox/open';  // Replace with the actual Python API URL

        try {
            // Send a POST request to the Python API
            $response = $this->client->request('POST', $url);

            // Handle the response from the API
            if ($response->getStatusCode() === 200) {
                // Successfully triggered the opening
                // You can log this or perform any other action here
                echo "Pilulier opened successfully.";
            } else {
                // Log or handle the error based on the status code
                echo "Failed to open the pilulier. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            // Handle any exceptions during the request
            echo "An error occurred while trying to open the pilulier: " . $e->getMessage();
        }
    }

    public function close(): void
    {
        $url = 'http://127.0.0.1:5000/pillbox/close';  // Replace with the actual Python API URL

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
    public function setDeliveryTime($h1, $h2, $h3, $h4): void {
        // The Python API URL with query parameters for h1, h2, h3, h4
        $url = "http://127.0.0.1:5000/pillbox/setDeliveryTime?h1={$h1}&h2={$h2}&h3={$h3}&h4={$h4}";
    
        try {
            $response = $this->client->request('POST', $url);
    
            if ($response->getStatusCode() === 200) {
                echo "Delivery times set successfully.";
            } else {
                echo "Failed to set delivery times. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to set the delivery times: " . $e->getMessage();
        }
    }
}
