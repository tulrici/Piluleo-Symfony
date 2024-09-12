<?php

namespace App\Entity;

use App\Repository\AdministrateurSystemeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateurSystemeRepository::class)]
class AdministrateurSysteme extends Utilisateur
{
    #[ORM\Column(nullable: true)]
    private ?int $idAdmin = null;

    public function getRole(): string
    {
        return 'ROLE_ADMIN';
    }

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
    }

    public function setIdAdmin(?int $idAdmin): static
    {
        $this->idAdmin = $idAdmin;
        return $this;
    }
}
