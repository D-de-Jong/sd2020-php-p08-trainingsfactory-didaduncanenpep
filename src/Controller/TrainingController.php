<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {

        $register = $em->getRepository(User::class)->findAll();
        $user = new User();

        $user->setRoles(array('ROLE_KLANT'));



        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);





        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            $this->addFlash('succes', 'Uw bestelling is doorgestuurd!');
            //  return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('training/register.html.twig', [
            'form' => $form

        ]);


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