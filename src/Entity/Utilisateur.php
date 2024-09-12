<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "administrateur" => "AdministrateurSysteme",
    "aidant" => "Aidant",
    "patient" => "Patient"
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

    // Remove the role property, as it's determined by the entity type

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): ?string
    {
        $this->nom = $nom;
        return $this->nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): ?string
    {
        $this->prenom = $prenom;
        return $this->prenom;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): ?string
    {
        $this->email = $email;
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->motDePasse;
    }
    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): ?string
    {
        $this->motDePasse = $motDePasse;
        return $this->motDePasse;
    }

    public function getRoles(): array
    {
        // The role is determined by the entity type
        $roles = [$this->getRole()];
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
