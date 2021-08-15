<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeRequestController extends AbstractController
{
    /**
     * @Route("/admin/changeRequests", name="app_admin_change_requests")
     */
    public function index(): Response
    {
        return $this->render('admin/ChangeRequest/index.html.twig', [
            'title' => 'CHANGE REQUEST',
        ]);
    }
}