<?php

namespace App\Controller;

use App\Entity\AdministrateurSysteme;
use App\Entity\Aidant;
use App\Entity\Patient;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Create the appropriate user entity based on the selected role
            switch ($data['role']) {
                case 'ROLE_ADMIN':
                    $user = new AdministrateurSysteme();
                    break;
                case 'ROLE_AIDANT':
                    $user = new Aidant();
                    break;
                case 'ROLE_PATIENT':
                    $user = new Patient();
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid role selected');
            }

            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $user->setEmail($data['email']);
            
            // Hash the password
            $user->setMotDePasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $data['motDePasse']
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User registered successfully!');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
