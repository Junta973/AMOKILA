<?php

namespace App\Controller\admin;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/admin/planning", name="app_admin_planning")
     */
    public function index(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        $tasksEvents = [];
        foreach ($tasks as $task)
            $tasksEvents[]=[
                'id' => 'T'.$task->getId(),
                'title' => 'Task '.$task->getTaskName().' ref: '.$task->getTaskRef(),
                'start' => ($task->getDateStart())->format('Y-m-d'),
                'end' => ($task->getDateEnd())->format('Y-m-d'),
                'color' => $task->getColor()
            ];



        return $this->render('admin/Planning/index.html.twig', [
            'title' => 'PLANNING',
            'tasksEvents' => json_encode($tasksEvents,true)
        ]);
    }
}