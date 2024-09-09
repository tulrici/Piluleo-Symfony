<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/create-account', name: 'admin_create_account')]
    public function createAccount(Request $request): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->generatePassword();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setMotDePasse($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->sendAccountCreationEmail($user, $password);

            $this->addFlash('success', 'Account created successfully.');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/create_account.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modify-account/{id}', name: 'admin_modify_account')]
    public function modifyAccount(Request $request, Utilisateur $user): Response
    {
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Account modified successfully.');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/modify_account.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/delete-account/{id}', name: 'admin_delete_account')]
    public function deleteAccount(Utilisateur $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'Account deleted successfully.');
        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/account-details/{id}', name: 'admin_account_details')]
    public function accountDetails(Utilisateur $user): Response
    {
        return $this->render('admin/account_details.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/assign-role/{id}', name: 'admin_assign_role')]
    public function assignRole(Request $request, Utilisateur $user): Response
    {
        // Implement role assignment logic here
        // You might want to create a form for this
    }

    #[Route('/raspberry-pi/reboot', name: 'admin_raspberry_pi_reboot')]
    public function rebootRaspberryPi(): Response
    {
        // Implement Raspberry Pi reboot logic here
        // This might involve making an API call to the Raspberry Pi
    }

    #[Route('/raspberry-pi/config', name: 'admin_raspberry_pi_config')]
    public function accessRaspberryPiConfig(): Response
    {
        // Implement logic to access Raspberry Pi config files
        // This might involve making an API call to the Raspberry Pi
    }

    private function generatePassword(): string
    {
        // Implement password generation logic
        return bin2hex(random_bytes(8));
    }

    private function sendAccountCreationEmail(Utilisateur $user, string $password): void
    {
        $email = (new Email())
            ->from('your-email@example.com')
            ->to($user->getEmail())
            ->subject('Your new account')
            ->text("Your account has been created.");

        $this->mailer->send($email);
    }
}
