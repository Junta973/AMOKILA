<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskRequestController extends AbstractController
{
    /**
     * @Route("/admin/taskRequest", name="app_admin_task_request")
     */
    public function index(): Response
    {
        return $this->render('admin/TaskRequest/index.html.twig', [
            'title' => 'TASK REQUEST',
        ]);
    }
}