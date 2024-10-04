<?php

namespace App\Controller;

use App\Entity\Pilulier;
use App\Form\PilulierType;
use App\Repository\PilulierRepository;
use App\Service\PilulierApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pilulier')]
final class PilulierController extends AbstractController
{
    private PilulierApiService $pilulierApiService;
    private EntityManagerInterface $entityManager;

    public function __construct(PilulierApiService $pilulierApiService, EntityManagerInterface $entityManager)
    {
        $this->pilulierApiService = $pilulierApiService;
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
        if ($this->isCsrfTokenValid('delete' . $pilulier->getId(), $request->get('_token'))) {
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

    #[Route('/open/{id}', name: 'app_pilulier_open')]
    public function open(Pilulier $pilulier): Response
    {
        $success = $this->pilulierApiService->open();

        if ($success) {
            return new Response("Pilulier with ID: {$pilulier->getId()} opened successfully.");
        } else {
            return new Response("Failed to open the pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/close/{id}', name: 'app_pilulier_close')]
    public function close(Pilulier $pilulier): Response
    {
        $success = $this->pilulierApiService->close();

        if ($success) {
            return new Response("Pilulier with ID: {$pilulier->getId()} closed successfully.");
        } else {
            return new Response("Failed to close the pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/change-hours/{id}', name: 'app_pilulier_change_hours')]
    public function changeHours(Pilulier $pilulier): Response
    {
        // Implement the changeHours logic using the service if applicable
        // Example:
        $success = $this->pilulierApiService->changeHours(); // Assuming you add this method

        if ($success) {
            return new Response("Pilulier with ID: {$pilulier->getId()} changed delivery hours.");
        } else {
            return new Response("Failed to change delivery hours for pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/power/{id}', name: 'app_pilulier_power')]
    public function power(Pilulier $pilulier): Response
    {
        $success = $this->pilulierApiService->power();

        if ($success) {
            return new Response("Pilulier with ID: {$pilulier->getId()} power toggled.");
        } else {
            return new Response("Failed to toggle power for pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/remote/{id}', name: 'app_pilulier_remote')]
    public function remote(Pilulier $pilulier): Response
    {
        $success = $this->pilulierApiService->remote();

        if ($success) {
            return new Response("Pilulier with ID: {$pilulier->getId()} remotely controlled.");
        } else {
            return new Response("Failed to remotely control pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/test-motor/{id}', name: 'app_pilulier_test_motor')]
    public function testMotor(Pilulier $pilulier): Response
    {
        $success = $this->pilulierApiService->testMotor();

        if ($success) {
            return new Response("Motor of Pilulier with ID: {$pilulier->getId()} tested.");
        } else {
            return new Response("Failed to test motor for pilulier with ID: {$pilulier->getId()}.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}