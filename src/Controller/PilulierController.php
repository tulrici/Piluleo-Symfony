<?php

namespace App\Controller;

use App\Entity\Pilulier;
use App\Form\PilulierType;
use App\Repository\PilulierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/pilulier')]
final class PilulierController extends AbstractController
{
    private HttpClientInterface $httpClient;

    // Inject HttpClientInterface in the controller's constructor
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    #[Route(name: 'app_pilulier_index', methods: ['GET'])]
    public function index(PilulierRepository $pilulierRepository): Response
    {
        return $this->render('pilulier/index.html.twig', [
            'piluliers' => $pilulierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pilulier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pilulier = new Pilulier($this->httpClient);
        $form = $this->createForm(PilulierType::class, $pilulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pilulier);
            $entityManager->flush();

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
    public function edit(Request $request, Pilulier $pilulier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PilulierType::class, $pilulier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pilulier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pilulier/edit.html.twig', [
            'pilulier' => $pilulier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pilulier_delete', methods: ['POST'])]
    public function delete(Request $request, Pilulier $pilulier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pilulier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pilulier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pilulier_index', [], Response::HTTP_SEE_OTHER);
    }
}
