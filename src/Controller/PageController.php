<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig');
    }

    #[Route('/privacy-policy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('pages/privacy.html.twig');
    }

    #[Route('/terms-of-service', name: 'app_terms')]
    public function terms(): Response
    {
        return $this->render('pages/terms.html.twig');
    }
}