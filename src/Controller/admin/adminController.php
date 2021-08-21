<?php

namespace App\Controller\admin;

use App\Repository\MaterialRepository;
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
        TaskRepository $taskRepository,
        MaterialRepository $materialRepository
    ): Response
    {

        $totalProject = $projectRepository->getNbrResults();
        $lastProjects = $projectRepository->getLastResluts(5);

        $totalPCR = $changeRequestRepository->getNbrResults();
        $lastPCRs = $changeRequestRepository->getLastResluts(5);

        $totalProcess = $processRepository->getNbrResults();
        $lastProcess = $processRepository->getLastResluts(5);

        $totalTasks = $taskRepository->getNbrResults();
        $lastTasks = $taskRepository->getLastResluts(5);

        $lastTasksInProgress = $taskRepository->getLastTaskOnProgress(5);

        $nbrPCRApprouved = $changeRequestRepository->getNbrResultsByStats('Approuved');
        $nbrPCRNewCR = $changeRequestRepository->getNbrResultsByStats('New CR');
        $nbrPCRInReview = $changeRequestRepository->getNbrResultsByStats('In Review');
        $nbrPCRRejected = $changeRequestRepository->getNbrResultsByStats('Rejected');

        $materialCount = $materialRepository->count([]);
        $materialValid = $materialRepository->countValide();


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
            'lastTasksInProgress' => $lastTasksInProgress,

            'nbrPCRApprouved' =>$nbrPCRApprouved,
            'nbrPCRNewCR' =>$nbrPCRNewCR,
            'nbrPCRInReview' =>$nbrPCRInReview,
            'nbrPCRRejected' =>$nbrPCRRejected,

            'materialCount' => $materialCount,
            'materialValid' => $materialValid
        ]);
    }
}
