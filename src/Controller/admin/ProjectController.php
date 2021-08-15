<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/project", name="app_admin_project")
     */
    public function index(): Response
    {
        return $this->render('admin/Project/index.html.twig', [
            'title' => 'PROJECT',
        ]);
    }
}