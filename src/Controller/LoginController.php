<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;

class LoginController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        // Si l'utilisateur est déjà connecté, redirigez-le vers le tableau de bord
        if ($security->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Récupérer l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide - elle sera interceptée par la clé de déconnexion de votre pare-feu
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé de déconnexion de votre pare-feu.');
    }
}