<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KlantController extends AbstractController
{
    #[Route('/klant', name: 'app_klant')]
    public function index(): Response
    {
        return $this->render('klant/index.html.twig', [
            'controller_name' => 'KlantController',
        ]);
    }
    #[Route('/profile', name: 'profile')]
    public function crud(Request $request, EntityManagerInterface $em): Response
    {
        $profile = $em->getRepository(User::class)->findAll();

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is verandert'
            );
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('klant/profile.html.twig', [
            'form' => $form

        ]);


    }

}
