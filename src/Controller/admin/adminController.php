<?php

namespace App\Controller\admin;

use App\Repository\ProcessRepository;
use App\Repository\ProjectChangeRequestRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class adminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(
        ProjectRepository $projectRepository,
        ProjectChangeRequestRepository $changeRequestRepository,
        ProcessRepository $processRepository,
        TaskRepository $taskRepository
    ): Response
    {

        $totalProject = $projectRepository->getNbrResults();
        $lastProjects = $projectRepository->getLastResluts(5);

        $totalPCR = $changeRequestRepository->getNbrResults();
        $lastPCRs = $changeRequestRepository->getLastResluts(5);

        $totalProcess = $changeRequestRepository->getNbrResults();
        $lastProcess = $changeRequestRepository->getLastResluts(5);

        $totalTasks = $taskRepository->getNbrResults();
        $lastTasks = $taskRepository->getLastResluts(5);

        $lastTasksInProgress = $taskRepository->getLastTaskOnProgress(5);

        return $this->render('admin/index.html.twig', [
            'title' => 'DASHBOARD',
            'totalProject' => $totalProject,
            'lastProjects' => $lastProjects,
            'totalPCR' => $totalPCR,
            'lastPCRs' => $lastPCRs,
            'totalProcess' => $totalProcess,
            'lastProcess' => $lastProcess,
            'totalTasks' => $totalTasks,
            'lastTasks' => $lastTasks,
            'lastTasksInProgress' => $lastTasksInProgress
        ]);
    }
}
