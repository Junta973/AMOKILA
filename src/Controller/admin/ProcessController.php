<?php

namespace App\Controller\admin;

use App\Entity\Process;
use App\Form\ProcessType;
use App\Repository\ProcessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcessController extends AbstractController
{
    /**
     * @Route("/admin/process", name="app_admin_process")
     */
    public function index(ProcessRepository $processRepository): Response
    {
        $allProcess = $processRepository->findAll();
        return $this->render('admin/Process/index.html.twig', [
            'title' => 'PROCESS',
            'allProcess' => $allProcess
        ]);
    }

    /**
     * @route("/admin/process/ajouter", name="app_admin_process_ajouter", methods={"GET","POST"})
     */
    public function ajouterProcess(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $process = new Process();
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $process = $form->getData();
            $entityManager->persist($process);
            $entityManager->flush();
            $this->addFlash('success','Process ajouter avec succès!');
            return $this->redirectToRoute('app_admin_process');
        }
        return $this->render('admin/Process/ajouterProcess.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/process/modifier/{id}", name="app_admin_process_modifier", methods={"GET","POST"})
     */
    public function modifierProcess(Request $request,ProcessRepository $processRepository,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $process = $processRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $process = $form->getData();
            $entityManager->persist($process);
            $entityManager->flush();
            $this->addFlash('success','Process modifié avec succès!');
            return $this->redirectToRoute('app_admin_process');
        }
        return $this->render('admin/Process/modifierProcess.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/process/delete/{id}", name="app_admin_process_delete", methods={"GET"})
     */
    public function deleteProcess(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $process = $entityManager->getRepository(Process::class)->findOneBy(['id'=>$id]);
        if($process){
            $entityManager->remove($process);
            $entityManager->flush();
            $this->addFlash('success','Process supprimé avec succès!');
        }else{
            $this->addFlash('danger','Process introuvable!');
        }

        return $this->redirectToRoute('app_admin_process');

    }

    /**
     * @route("/admin/process/view/{id}", name="app_admin_process_view", methods={"GET"})
     */
    public function viewProcess(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $process = $entityManager->getRepository(Process::class)->findOneBy(['id'=>$id]);
        return $this->render('admin/Process/viewProcess.html.twig',['process'=>$process]);
    }
}