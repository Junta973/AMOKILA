<?php

namespace App\Controller\admin;

use App\Entity\ProjectChangeRequest;
use App\Form\ProjectChangeRequestType;
use App\Repository\ProjectChangeRequestRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeRequestController extends AbstractController
{
    /**
     * @Route("/admin/changeRequests", name="app_admin_change_requests")
     */
    public function index(Request $request,ProjectChangeRequestRepository $repository): Response
    {

        $pcrref = $request->request->get('pcrref');
        $pcrname = $request->request->get('pcrname');
        $pcretat = $request->request->get('pcretat');

        if($this->isGranted("ROLE_ADMIN"))
            $allProjectRequests = $repository->search($pcrref,$pcrname,$pcretat,null);
        else
            $allProjectRequests = $repository->search($pcrref,$pcrname,$pcretat,$this->getUser());


        return $this->render('admin/ChangeRequest/index.html.twig', [
            'title' => 'CHANGE REQUEST',
            'allProjectRequests' => $allProjectRequests
        ]);
    }

    /**
     * @Route("/admin/changeRequests/ajouter",name="app_admin_change_request_ajouter")
     */
    public function ajouterChangeRequest(Request $request,EntityManagerInterface $em): Response
    {
        $changeRequest = new ProjectChangeRequest();
        $form = $this->createForm(ProjectChangeRequestType::class,$changeRequest);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
            $changeRequest->setRequestedBy($this->getUser());
            $em->persist($changeRequest);
            $em->flush();
            $this->addFlash('success','Change request ajouté avec succès');
            return $this->redirectToRoute('app_admin_change_requests');
        }
        return $this->render('admin/ChangeRequest/ajouterChangeRequest.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/changeRequests/modifier/{id}",name="app_admin_change_request_modifier")
     */
    public function modifierChangeRequest(Request $request,EntityManagerInterface $em,ProjectChangeRequestRepository $repository,$id): Response
    {
        $changeRequest = $repository->findOneBy(['id'=>$id]);
        if (!$changeRequest){
            $this->addFlash('danger','Change request introuvable');
            return $this->redirectToRoute('app_admin_change_requests');
        }

        $form = $this->createForm(ProjectChangeRequestType::class,$changeRequest);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){

            if ($changeRequest->getPcrStatus() != "New CR"){
                $changeRequest->setApprouvedBy($this->getUser());
                $changeRequest->setApprovalDate(new \DateTime());
            }

            $em->persist($changeRequest);
            $em->flush();
            $this->addFlash('success','Change request modifié avec succès');
            return $this->redirectToRoute('app_admin_change_requests');
        }
        return $this->render('admin/ChangeRequest/modifierChangeRequest.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/changeRequests/view/{id}",name="app_admin_change_request_view")
     */
    public function viewChangeRequest(Request $request,ProjectChangeRequestRepository $repository,$id): Response
    {
        $changeRequest = $repository->findOneBy(['id'=>$id]);
        if (!$changeRequest){
            $this->addFlash('danger','Change request introuvable');
            return $this->redirectToRoute('app_admin_change_requests');
        }

        return $this->render('admin/ChangeRequest/viewChangeRequest.html.twig',['changeRequest'=>$changeRequest]);
    }

    /**
     * @Route("/admin/changeRequests/delete/{id}",name="app_admin_change_request_delete")
     */
    public function deleteChangeRequest(Request $request,EntityManagerInterface $em,ProjectChangeRequestRepository $repository,$id): Response
    {
        $changeRequest = $repository->findOneBy(['id'=>$id]);
        if (!$changeRequest){
            $this->addFlash('danger','Change request introuvable');
            return $this->redirectToRoute('app_admin_change_requests');
        }
        try {
            $em->remove($changeRequest);
            $em->flush();
            $this->addFlash('success','Change request supprimé avec succès');
        }catch (\Exception $exception){
            $this->addFlash('danger','Error System');
        }
        return $this->redirectToRoute('app_admin_change_requests');
    }


}