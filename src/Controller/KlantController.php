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

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user);

            return $this->redirectToRoute('profile');

        }


        return $this->renderForm('klant/profile.html.twig',[
            'form'=> $form
        ]);
    }

}
