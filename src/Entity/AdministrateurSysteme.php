<?php

namespace App\Entity;

use App\Repository\AdministrateurSystemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: AdministrateurSystemeRepository::class)]
class AdministrateurSysteme extends Utilisateur implements PasswordAuthenticatedUserInterface
{
    public function getRole(): string
    {
        return 'ROLE_ADMIN';
    }

}