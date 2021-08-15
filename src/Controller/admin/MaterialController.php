<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterialController extends AbstractController
{
    /**
     * @Route("/admin/material", name="app_admin_material")
     */
    public function index(): Response
    {
        return $this->render('admin/Material/index.html.twig', [
            'title' => 'MATERIALS LIST',
        ]);
    }
}