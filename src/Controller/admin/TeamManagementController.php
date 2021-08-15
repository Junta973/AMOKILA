<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamManagementController extends AbstractController
{
    /**
     * @Route("/admin/TeamManagement", name="app_admin_team_management")
     */
    public function index(): Response
    {
        return $this->render('admin/TeamManagement/index.html.twig', [
            'title' => 'TEAM MANAGEMENT',
        ]);
    }
}