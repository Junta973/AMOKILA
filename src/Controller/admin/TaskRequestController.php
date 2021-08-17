<?php

namespace App\Controller\admin;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskRequestController extends AbstractController
{
    /**
     * @Route("/admin/taskRequest", name="app_admin_task_request")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        return $this->render('admin/TaskRequest/index.html.twig', [
            'title' => 'TASK REQUEST',
            'tasks' => $tasks
        ]);
    }

    /**
     * @route("/admin/taskRequest/ajouter", name="app_admin_taskRequest_ajouter", methods={"GET","POST"})
     */
    public function ajoutertaskRequest(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success','Task ajouter avec succès!');
            return $this->redirectToRoute('app_admin_task_request');
        }
        return $this->render('admin/TaskRequest/ajouterTask.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/taskRequest/modifier/{id}", name="app_admin_taskRequest_modifier", methods={"GET","POST"})
     */
    public function modifiertaskRequest(Request $request,TaskRepository $taskRepository,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $taskRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success','Task modifié avec succès!');
            return $this->redirectToRoute('app_admin_task_request');
        }
        return $this->render('admin/TaskRequest/modifierTask.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/taskRequest/delete/{id}", name="app_admin_taskRequest_delete", methods={"GET"})
     */
    public function deletetaskRequest(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['id'=>$id]);
        if($task){
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success','Task supprimé avec succès!');
        }else{
            $this->addFlash('danger','Task introuvable!');
        }

        return $this->redirectToRoute('app_admin_task_request');

    }

    /**
     * @route("/admin/taskRequest/view/{id}", name="app_admin_taskRequest_view", methods={"GET"})
     */
    public function viewtaskRequest(Request $request,$id): Response
    {
        return $this->render('admin/Process/viewProcess.html.twig');
    }
}