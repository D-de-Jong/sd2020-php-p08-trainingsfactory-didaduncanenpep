<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;


class   KlantController extends AbstractController
{
    #[Route('/klant', name: 'app_klant')]
    public function index(): Response
    {
        return $this->render('klant/index.html.twig', [
            'controller_name' => 'KlantController',
        ]);
    }
    #[Route('/profile', name: 'profile')]
    public function profile(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            $userRepository->save($user, true);

            return $this->redirectToRoute('app_klant');

        }


        return $this->renderForm('klant/profile.html.twig',[
            'form'=> $form
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
