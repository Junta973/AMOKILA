<?php

namespace App\Controller\admin;

use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjetType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/project", name="app_admin_project")
     */
    public function index(Request $request,ProjectRepository $projectRepository): Response
    {

        $ref = $request->request->get('refprojet');
        $name = $request->request->get('nameprojet');

        $projects = $projectRepository->search($name,$ref);
        return $this->render('admin/Project/index.html.twig', [
            'title' => 'PROJECT',
            'projects' => $projects
        ]);
    }

    /**
     * @route("/admin/project/ajouter", name="app_admin_project_ajouter", methods={"GET","POST"})
     */
    public function ajouterProjet(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $projet = new Project();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash('success','Projet ajouter avec succès!');
            return $this->redirectToRoute('app_admin_project');
        }
        return $this->render('admin/Project/ajouterProjet.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/project/modifier/{id}", name="app_admin_project_modifier", methods={"GET","POST"})
     */
    public function modifierProjet(Request $request,ProjectRepository $projectRepository,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $projet = $projectRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash('success','Projet modifié avec succès!');
            return $this->redirectToRoute('app_admin_project');
        }
        return $this->render('admin/Project/modifierProjet.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/project/delete/{id}", name="app_admin_project_delete", methods={"GET"})
     */
    public function deleteProjet(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id'=>$id]);
        if($project){
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash('success','Projet supprimé avec succès!');
        }else{
            $this->addFlash('danger','Projet introuvable!');
        }

        return $this->redirectToRoute('app_admin_project');

    }

    /**
     * @route("/admin/project/view/{id}", name="app_admin_project_view", methods={"GET"})
     */
    public function viewProjet(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProjetType::class, $project);
        $form->handleRequest($request);
        return $this->render('admin/Project/viewProject.html.twig',['project'=>$project,"form" => $form->createView()]);
    }


}