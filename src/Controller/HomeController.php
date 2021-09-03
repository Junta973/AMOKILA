<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #Route vers la home page
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    #Route vers contact
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact()
    {
        return $this->render('home/index.html.twig');
    }

    #Route vers about
    /**
     * @Route("/apropos", name="app_apropos")
     */
    public function apropos()
    {
        return $this->render('home/index.html.twig');
    }
}
