<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Training;
use App\Form\LessonType;
use App\Form\TrainingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    #[Route('/instructor', name: 'app_instructor')]
    public function index(): Response
    {
        return $this->render('instructor/index.html.twig', [
            'controller_name' => 'instructorController',
        ]);
    }
    #[Route('/add-lesson', name: 'add-lesson')]
    public function showInsert(Request $request, EntityManagerInterface $em): Response
    {
        $genre = $em->getRepository(Lesson::class)->findAll();
        $add = new Lesson();
        $form = $this->createForm(LessonType::class, $add);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is toegevoegd'
            );
            return $this->redirectToRoute('app_instructor');

        }

        return $this->renderForm('instructor/addlesson.html.twig', [
            'form' => $form

        ]);
    }
}
