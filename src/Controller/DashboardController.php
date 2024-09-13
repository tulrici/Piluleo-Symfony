<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Déterminer les rôles de l'utilisateur
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isAidant = $this->isGranted('ROLE_AIDANT');
        $isPatient = $this->isGranted('ROLE_PATIENT');

        // Si l'utilisateur n'a aucun de ces rôles spécifiques, on considère qu'il est un patient par défaut
        if (!$isAdmin && !$isAidant && !$isPatient) {
            $isPatient = true;
        }

        // Vous pouvez ajouter ici la logique pour récupérer les données nécessaires au tableau de bord

        return $this->render('dashboard/dashboard.html.twig', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'isAidant' => $isAidant,
            'isPatient' => $isPatient,
        ]);
    }
}
