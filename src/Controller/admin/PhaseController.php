<?php

namespace App\Controller\admin;

use App\Entity\Phase;
use App\Form\PhaseType;
use App\Repository\PhaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhaseController extends AbstractController
{
    # Route create+update
    /**
     * @Route("/admin/phase/{id}", defaults={"id"=null}, name="app_admin_phase")
     */
    public function index(Request $request,EntityManagerInterface $entityManager,PhaseRepository $phaseRepository,$id)
    {
        #Test si la phase exist
        if(is_null($id))
            #Si elle n'existe pas alors je la créer
            $phase = new Phase();
        else
            #Sinon je la cherche par son id
            $phase = $phaseRepository->findOneBy(['id'=>$id]);

        #Création du formulaire
        $form = $this->createForm(PhaseType::class, $phase);

        #traiter les données du formulaire + vérification
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($phase);
            $entityManager->flush();
            $this->addFlash('success','Phase enregistré avec succès!');
            return $this->redirectToRoute('app_admin_phase');
        }

        #Je recupère toutes les phases
        $allPhases = $phaseRepository->findAll();
        #Je renvoie vers le twig view
        return $this->render('admin/ProjectPhase/projectPhase.html.twig', [
            'title' => 'PHASE CONFIGURATION',
            'allphases' => $allPhases,
            'form' => $form->createView()
        ]);
    }

    # Route delete phase
    /**
     * @Route("/admin/phase/delete/{id}", name="app_admin_phase_delete", methods={"GET"})
     */
    public function deletePhase(Request $request,EntityManagerInterface $entityManager, $id)
    {
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
