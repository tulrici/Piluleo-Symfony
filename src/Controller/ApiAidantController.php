<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\AidantController;

#[Route('/api/aidant')]
class ApiAidantController extends AbstractController
{
    #[Route('{id}/open', name: 'app_api_aidant_open', methods: ['GET'])]
    public function apiAidantOpen(): Response
    {
        $this->AidantController->open();
        $data = [
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiAidantController.php',
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
