<?php

namespace App\Controller;
use App\Entity\Lesson;
use App\Entity\Training;
use App\Entity\User;
use App\Form\RegisterType;
use App\Form\TrainingType;
use App\Form\UpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function updateMember(Request $request, EntityManagerInterface $em,int $id): Response
    {
        $training = $em->getRepository(User::class)->find($id);

        $form = $this->createForm(RegisterType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is verandert'
            );
            return $this->redirectToRoute('members');
        }

        return $this->renderForm('admin/updatemember.html.twig', [
            'form' => $form

        ]);

    }
    #[Route('/deletemember/{id}', name: 'deleteMember')]
    public function deleteMembers(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(User::class)->find($id);{


        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'het item is verwijdert'
        );
        return $this->redirectToRoute('members');
    }

    }
    #[Route('/instructor-crud', name: 'instructor-crud')]
    public function allInstructor(EntityManagerInterface $entityManager): Response
    {
        $member = $entityManager->getRepository(User::class)->findAll();


        return $this->render('admin/instructor.html.twig', [
            'members' => $member]);
    }
    #[Route('/update-instructor/{id}', name: 'updateInstructor')]
    public function updateInstructor(Request $request, EntityManagerInterface $em,int $id): Response
    {
        $training = $em->getRepository(User::class)->find($id);

        $form = $this->createForm(RegisterType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is verandert'
            );
            return $this->redirectToRoute('members');
        }

        return $this->renderForm('admin/updateinstructor.html.twig', [
            'form' => $form

        ]);
    }
    #[Route('/deleteinstructor/{id}', name: 'deleteInstructor')]
    public function deleteInstructor(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(User::class)->find($id);{


        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'het item is verwijdert'
        );
        return $this->redirectToRoute('members');
    }

    }
    #[Route('/insertinstructor', name: 'addtraining')]
    public function insertInstructor(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $genre = $em->getRepository(User::class)->findAll();
        $add = new User();
        $add->setRoles(array('ROLE_INSTRUCTOR'));
        $form = $this->createForm(RegisterType::class, $add);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $add->setPassword($passwordHasher->hashPassword($add, $add->getPassword()));

            $em->persist($add);
            $em->flush();
            $this->addFlash(
                'notice',
                'het item is toegevoegd'
            );
            return $this->redirectToRoute('instructor-crud');

        }

        return $this->renderForm('admin/training.html.twig', [
            'form' => $form

        ]);
    }

}
