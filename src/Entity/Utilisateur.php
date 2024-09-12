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

    }

    public function eraseCredentials(): void
    {
        // Si vous stockez des données temporaires sensibles sur l'utilisateur, effacez-les ici
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
