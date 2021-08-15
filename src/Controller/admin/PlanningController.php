<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    /**
     * @Route("/admin/planning", name="app_admin_planning")
     */
    public function index(): Response
    {
        return $this->render('admin/Planning/index.html.twig', [
            'title' => 'PLANNING',
        ]);
    }
}