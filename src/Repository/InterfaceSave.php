<?php

namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class InterfaceSave extends ServiceEntityRepository
{
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}