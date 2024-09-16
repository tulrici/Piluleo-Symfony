<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "role", type: "string")]
#[ORM\DiscriminatorMap([
    "ROLE_ADMIN" => AdministrateurSysteme::class,
    "ROLE_AIDANT" => Aidant::class,
    "ROLE_PATIENT" => Patient::class
])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $nom = null;

    #[ORM\Column(length: 255)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 255, unique: true)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    protected ?string $motDePasse = null;

    // No more role field here

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    // This method will return roles based on the discriminator column
    public function getRoles(): array
    {
        $roles = [$this->getRole()];
        $roles[] = 'ROLE_USER'; // Guarantee every user at least has ROLE_USER
        return array_unique($roles);
    }

    // Get role from discriminator column
    public function getRole(): string
    {
        // The discriminator column will handle the role
        return $this instanceof AdministrateurSysteme ? 'ROLE_ADMIN' :
               ($this instanceof Aidant ? 'ROLE_AIDANT' :
               ($this instanceof Patient ? 'ROLE_PATIENT' : 'ROLE_USER'));
    }

    public function eraseCredentials(): void
    {
        // Clear sensitive data if any
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->motDePasse;
    }
}

