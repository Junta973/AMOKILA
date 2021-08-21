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
     * @Route("/admin/taskList", name="app_admin_task_list")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        return $this->render('admin/Task/index.html.twig', [
            'title' => 'TASK LIST',
            'tasks' => $tasks
        ]);
    }

    /**
     * @route("/admin/taskList/ajouter", name="app_admin_taskList_ajouter", methods={"GET","POST"})
     */
    public function ajoutertaskList(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success','Task ajouter avec succès!');
            return $this->redirectToRoute('app_admin_task_list');
        }
        return $this->render('admin/Task/ajouterTask.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/taskList/modifier/{id}", name="app_admin_taskList_modifier", methods={"GET","POST"})
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
            return $this->redirectToRoute('app_admin_task_list');
        }
        return $this->render('admin/Task/modifierTask.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/taskList/delete/{id}", name="app_admin_taskList_delete", methods={"GET"})
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

        return $this->redirectToRoute('app_admin_task_list');

    }

    /**
     * @route("/admin/taskList/view/{id}", name="app_admin_taskList_view", methods={"GET"})
     */
    public function viewtaskRequest(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['id'=>$id]);
        return $this->render('admin/Task/viewTask.html.twig',['task'=>$task]);
    }
}