<?php

namespace App\Controller;

use App\Entity\Pilulier;
use App\Form\PilulierType;
use App\Repository\PilulierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/pilulier')]
final class PilulierController extends AbstractController
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }
    
    #[Route(name: 'app_pilulier_index', methods: ['GET'])]
    public function index(PilulierRepository $pilulierRepository): Response
    {
        return $this->render('pilulier/index.html.twig', [
            'piluliers' => $pilulierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pilulier_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pilulier = new Pilulier();
        $form = $this->createForm(PilulierType::class, $pilulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($pilulier);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pilulier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pilulier/new.html.twig', [
            'pilulier' => $pilulier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pilulier_show', methods: ['GET'])]
    public function show(Pilulier $pilulier): Response
    {
        return $this->render('pilulier/show.html.twig', [
            'pilulier' => $pilulier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pilulier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pilulier $pilulier): Response
    {
        $form = $this->createForm(PilulierType::class, $pilulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pilulier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pilulier/edit.html.twig', [
            'pilulier' => $pilulier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pilulier_delete', methods: ['POST'])]
    public function delete(Request $request, Pilulier $pilulier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pilulier->getId(), $request->get('_token'))) {
            $this->entityManager->remove($pilulier);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_pilulier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/command/{id}', name: 'app_pilulier_command', methods: ['GET'])]
    public function command(Pilulier $pilulier): Response
    {
        return $this->render('pilulier/command.html.twig', [
            'pilulier' => $pilulier,
        ]);
    }

    #[Route('/pilulier/open/{id}', name: 'app_pilulier_open')]
    public function open(Pilulier $pilulier): Response
    {
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/open');
        return new Response("Pilulier with ID: {$pilulier->getId()} opened successfully.");
    }

    #[Route('/pilulier/close/{id}', name: 'app_pilulier_close')]
    public function close(Pilulier $pilulier): Response
    {
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/close');
        return new Response("Pilulier with ID: {$pilulier->getId()} closed successfully.");
    }

    #[Route('/pilulier/change-hours/{id}', name: 'app_pilulier_change_hours')]
    public function changeHours(Pilulier $pilulier): Response
    {
        // Add logic to change delivery hours here
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/change-hours');
        return new Response("Pilulier with ID: {$pilulier->getId()} changed delivery hours.");
    }

    #[Route('/pilulier/power/{id}', name: 'app_pilulier_power')]
    public function power(Pilulier $pilulier): Response
    {
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/power');
        return new Response("Pilulier with ID: {$pilulier->getId()} power toggled.");
    }

    #[Route('/pilulier/remote/{id}', name: 'app_pilulier_remote')]
    public function remote(Pilulier $pilulier): Response
    {
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/remote');
        return new Response("Pilulier with ID: {$pilulier->getId()} remotely controlled.");
    }

    #[Route('/pilulier/test-motor/{id}', name: 'app_pilulier_test_motor')]
    public function testMotor(Pilulier $pilulier): Response
    {
        $this->sendRequestToPythonAPI('http://10.20.0.54:5000/pillbox/test-motor');
        return new Response("Motor of Pilulier with ID: {$pilulier->getId()} tested.");
    }

    /**
     * Utility method to send an HTTP POST request to the Python API.
     */
    private function sendRequestToPythonAPI(string $url): void
    {
        try {
            $response = $this->httpClient->request('POST', $url);

            if ($response->getStatusCode() !== 200) {
                echo "Failed to send the request to the API. Status code: " . $response->getStatusCode();
            }
        } catch (\Exception $e) {
            echo "An error occurred while trying to communicate with the Python API: " . $e->getMessage();
        }
    }
}