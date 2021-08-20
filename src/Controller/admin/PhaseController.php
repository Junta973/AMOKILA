<?php

namespace App\Controller\admin;

use App\Entity\Phase;
use App\Form\PhaseType;
use App\Repository\PhaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhaseController extends AbstractController
{
    /**
     * @Route("/admin/phase/{id}", defaults={"id"=null}, name="app_admin_phase")
     */
    public function index(Request $request,PhaseRepository $phaseRepository,$id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        if(is_null($id))
            $phase = new Phase();
        else
            $phase = $phaseRepository->findOneBy(['id'=>$id]);

        $form = $this->createForm(PhaseType::class, $phase);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($phase);
            $entityManager->flush();
            $this->addFlash('success','Phase enregistré avec succès!');
            return $this->redirectToRoute('app_admin_phase');
        }

        $allPhases = $phaseRepository->findAll();
        return $this->render('admin/ProjectPhase/projectPhase.html.twig', [
            'title' => 'PHASE CONFIGURATION',
            'allphases' => $allPhases,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/phase/delete/{id}", name="app_admin_phase_delete", methods={"GET"})
     */
    public function deletePhase(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Material = $entityManager->getRepository(Phase::class)->findOneBy(['id'=>$id]);
        if($Material){
            $entityManager->remove($Material);
            $entityManager->flush();
            $this->addFlash('success','Phase supprimé avec succès!');
        }else{
            $this->addFlash('danger','Phase introuvable!');
        }

        return $this->redirectToRoute('app_admin_phase');

    }

}
