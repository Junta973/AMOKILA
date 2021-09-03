<?php

namespace App\Controller\admin;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #Route vers la page planning
    /**
     * @Route("/admin/planning", name="app_admin_planning")
     */
    public function index(TaskRepository $taskRepository)
    {
        #Je recupère les données des taches dans le taskRepository
        $tasks = $taskRepository->findAll();
        #Je créer une variable en tableaux pour récupérer les infos qque je veux
        $tasksEvents = [];
        #Boucle pour chaque tache
        foreach ($tasks as $task)
            $tasksEvents[]=[
                'id' => 'T'.$task->getId(),
                'title' => 'Task '.$task->getTaskName().' ref: '.$task->getTaskRef(),
                'start' => ($task->getDateStart())->format('Y-m-d'),
                'end' => ($task->getDateEnd())->format('Y-m-d'),
                'color' => $task->getColor()
            ];


        #je renvoie la réponse vers mon twig
        return $this->render('admin/Planning/index.html.twig', [
            'title' => 'PLANNING',
            'tasksEvents' => json_encode($tasksEvents,true)
        ]);
    }
}