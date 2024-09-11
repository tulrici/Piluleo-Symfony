<?php

namespace App\Controller;

use App\Entity\Ordonnance;
use App\Entity\Patient;
use App\Entity\Pilulier;
use App\Form\OrdonnanceType;
use App\Form\PatientType;
use App\Repository\OrdonnanceRepository;
use App\Repository\PatientRepository;
use App\Repository\PilulierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aidant")
 */
class AidantController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ordonnance", name="ordonnance_index", methods={"GET"})
     */
    public function indexOrdonnance(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('aidant/ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ordonnance/new", name="ordonnance_new", methods={"GET", "POST"})
     */
    public function newOrdonnance(Request $request): Response
    {
        $ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($ordonnance);
            $this->entityManager->flush();

            return $this->redirectToRoute('ordonnance_index');
        }

        return $this->render('aidant/ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordonnance/{id}", name="ordonnance_show", methods={"GET"})
     */
    public function showOrdonnance(Ordonnance $ordonnance): Response
    {
        return $this->render('aidant/ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    /**
     * @Route("/ordonnance/{id}/edit", name="ordonnance_edit", methods={"GET", "POST"})
     */
    public function editOrdonnance(Request $request, Ordonnance $ordonnance): Response
    {
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('ordonnance_index');
        }

        return $this->render('aidant/ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ordonnance/{id}", name="ordonnance_delete", methods={"POST"})
     */
    public function deleteOrdonnance(Request $request, Ordonnance $ordonnance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($ordonnance);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('ordonnance_index');
    }

    // CRUD for Patients

    /**
     * @Route("/patient", name="patient_index", methods={"GET"})
     */
    public function indexPatient(PatientRepository $patientRepository): Response
    {
        return $this->render('aidant/patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/patient/new", name="patient_new", methods={"GET", "POST"})
     */
    public function newPatient(Request $request): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($patient);
            $this->entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('aidant/patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/patient/{id}", name="patient_show", methods={"GET"})
     */
    public function showPatient(Patient $patient): Response
    {
        return $this->render('aidant/patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/patient/{id}/edit", name="patient_edit", methods={"GET", "POST"})
     */
    public function editPatient(Request $request, Patient $patient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('aidant/patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/patient/{id}", name="patient_delete", methods={"POST"})
     */
    public function deletePatient(Request $request, Patient $patient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($patient);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('patient_index');
    }

    // Method to Open Pilulier

    /**
     * @Route("/pilulier/open/{id}", name="pilulier_open", methods={"POST"})
     */
    public function openPilulier(PilulierRepository $pilulierRepository, $id): Response
    {
        $pilulier = $pilulierRepository->find($id);

        if (!$pilulier) {
            throw $this->createNotFoundException('Pillulier not found.');
        }

        // Here you would trigger the actual hardware to open the pill dispenser
        //TODO : Implement the open method in Pilulier entity
        $pilulier->open();  // Assuming there's a method in Pilulier that opens it

        return new Response('Pilulier opened successfully.');
    }
    public function setDeliveryPilulier(PilulierRepository $pilulierRepository, $id): Response
    {
        $pilulier = $pilulierRepository->find($id);

        if (!$pilulier) {
            throw $this->createNotFoundException('Pillulier not found.');
        }

        // Here you would trigger the actual hardware to open the pill dispenser
        //TODO : Implement the open method in Pilulier entity
        $pilulier->setDeliveryTime();  // Assuming there's a method in Pilulier that opens it

        return new Response('Timer set to h1, h2, h3, h4.');
    }
}