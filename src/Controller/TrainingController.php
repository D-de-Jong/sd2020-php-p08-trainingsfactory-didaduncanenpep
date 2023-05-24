<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController

{
    #[Route('/', name: 'home')]
    public function show(EntityManagerInterface $doctrine): Response
    {


        return $this->render('training/index.html.twig');
    }


    #[Route('/contact')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('training/contact.html.twig', [
            'number' => $number,
        ]);
    }

}