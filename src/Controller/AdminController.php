<?php

namespace App\Controller;
use App\Entity\Training;
use App\Entity\User;
use App\Form\TrainingType;
use App\Form\UpdateType;
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
            return $this->redirectToRoute('crud');

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
    public function update(Request $request, EntityManagerInterface $em,int $id): Response
    {
        $training = $em->getRepository(Training::class)->find($id);

        $form = $this->createForm(UpdateType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is verandert'
            );
            return $this->redirectToRoute('crud');
        }

        return $this->renderForm('admin/update.html.twig', [
            'form' => $form

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
        return $this->redirectToRoute('crud');
    }


    }
    #[Route('/members', name: 'members')]
    public function allMembers(EntityManagerInterface $entityManager): Response
    {
        $member = $entityManager->getRepository(User::class)->findAll();


        return $this->render('admin/leden.html.twig', [
            'members' => $member
        ]);
    }
    #[Route('/updatemember/{id}', name: 'updateMember')]
    public function updateMembers(EntityManagerInterface $entityManager): Response
    {
        $member = $entityManager->getRepository(User::class)->findAll();


        return $this->render('admin/updateMember.html.twig', [
            'members' => $member
        ]);
    }
    #[Route('/deletemember/{id}', name: 'deleteMember')]
    public function deleteMembers(EntityManagerInterface $entityManager): Response
    {
        $member = $entityManager->getRepository(User::class)->findAll();


        return $this->render('admin/deleteMember.html.twig', [
            'members' => $member
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
