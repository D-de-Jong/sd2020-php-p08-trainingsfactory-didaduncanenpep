<?php

namespace App\Controller;

use App\Entity\Training;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TrainingController extends AbstractController

{
    #[Route('/', name: 'home')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();

        return $this->render('training/index.html.twig', [
            'trainings' => $training
        ]);

    }


    #[Route('/contact',)]
    public function contact(): Response
    {

        return $this->render('training/contact.html.twig', [
        ]);
    }
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login.html.twig', [
            'controller_name' => 'TrainingController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

    }
    #[Route('/register', name: 'register')]
    public function register(): Response
    {

        return new Response('register');


    }
    #[Route('/redirect', name: 'redirect')]
    public function redirectAction(Security $security): Response
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }
        if ($security->isGranted('ROLE_KLANT')) {
            return $this->redirectToRoute('app_klant');
        }
        return $this ->$this->redirectToRoute('app_default');

    }

}