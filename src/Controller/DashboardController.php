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
        
        // Vous pouvez ajouter ici la logique pour récupérer les données nécessaires au tableau de bord

        return $this->render('dashboard/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}
