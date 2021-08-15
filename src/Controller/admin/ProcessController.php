<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcessController extends AbstractController
{
    /**
     * @Route("/admin/process", name="app_admin_process")
     */
    public function index(): Response
    {
        return $this->render('admin/Process/index.html.twig', [
            'title' => 'PROCESS',
        ]);
    }
}