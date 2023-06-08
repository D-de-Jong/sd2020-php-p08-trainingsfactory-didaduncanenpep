<?php

namespace App\Controller;
use App\Entity\Training;
use App\Form\TrainingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();


        return $this->render('admin/index.html.twig', [
            'trainings' => $training
        ]);
    }
    #[Route('/add-training', name: 'addtraining')]
    public function showInsert(Request $request, EntityManagerInterface $em): Response
    {
        $genre = $em->getRepository(Training::class)->findAll();
        $add = new Training();
        $form = $this->createForm(TrainingType::class, $add);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is toegevoegd'
            );
            return $this->redirectToRoute('home');

        }

        return $this->renderForm('admin/training.html.twig', [
            'form' => $form

        ]);
    }
    #[Route('/training-crud', name: 'crud')]
    public function crud(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();


        return $this->render('admin/crud.html.twig', [
            'trainings' => $training
        ]);
    }

    #[Route('/update/{id}', name: 'updateTraining')]
    public function update(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();


        return $this->render('admin/update.html.twig', [
            'trainings' => $training
        ]);
    }
    #[Route('/delete/{id}', name: 'deleteTraining')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Training::class)->find($id);{


        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'het item is verwijdert'
        );
        return $this->redirectToRoute('admin');
    }

        return $this->render(
            "delete.html.twig",['autos' => $product]);
    }
}
