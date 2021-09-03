<?php

namespace App\Controller\admin;

use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjetType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
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

        # recupération des paramaters de formulaire recherche
        $ref = $request->request->get('refprojet');
        $name = $request->request->get('nameprojet');

        # on pass les parameters vers la method search et filtrer la resultat
        $projects = $projectRepository->search($name,$ref);

        # envoie de projects vers le twig
        return $this->render('admin/Project/index.html.twig', [
            'title' => 'PROJECT',
            'projects' => $projects
        ]);
    }

    /**
     * @route("/admin/project/ajouter", name="app_admin_project_ajouter", methods={"GET","POST"})
     */
    public function ajouterProjet(Request $request,EntityManagerInterface $entityManager): Response
    {
        # création de new project
        $projet = new Project();

        # création de formulaire
        $form = $this->createForm(ProjetType::class, $projet);

        # le submit de form et validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $entityManager->persist($projet);
            $entityManager->flush();

            # message d'alert
            $this->addFlash('success','Projet ajouter avec succès!');

            # redirect vers la page liste
            return $this->redirectToRoute('app_admin_project');
        }

        # l'envoie de form vers le twig
        return $this->render('admin/Project/ajouterProjet.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/project/modifier/{id}", name="app_admin_project_modifier", methods={"GET","POST"})
     */
    public function modifierProjet(Request $request,ProjectRepository $projectRepository,EntityManagerInterface $entityManager,$id): Response
    {
        # get projet par id
        $projet = $projectRepository->findOneBy(['id'=>$id]);


        # creation de formulaire
        $form = $this->createForm(ProjetType::class, $projet);

        # le submit et le validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $entityManager->persist($projet);
            $entityManager->flush();

            # le message d'alert
            $this->addFlash('success','Projet modifié avec succès!');

            # le redirect vers la page liste de projets
            return $this->redirectToRoute('app_admin_project');
        }

        # l'envoie de form vers le twig
        return $this->render('admin/Project/modifierProjet.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/project/delete/{id}", name="app_admin_project_delete", methods={"GET"})
     */
    public function deleteProjet(Request $request,EntityManagerInterface $entityManager, $id): Response
    {
        # get projet par id
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id'=>$id]);

        # si projet exit
        if($project){
            if (
                count($project->getTasks()) != 0 ||
                count($project->getProjectChangeRequests()) != 0
            ){
                $this->addFlash('danger','Vous ne pouvez pas supprimer ce projet!');
            }else {

                # on va supprimé le projet
                $entityManager->remove($project);
                $entityManager->flush();
                $this->addFlash('success', 'Projet supprimé avec succès!');
            }
        }else{

            # sinon on affiche le message d'alert
            $this->addFlash('danger','Projet introuvable!');
        }

        # on redirige vers la page de projet
        return $this->redirectToRoute('app_admin_project');

    }

    /**
     * @route("/admin/project/view/{id}", name="app_admin_project_view", methods={"GET"})
     */
    public function viewProjet(Request $request,EntityManagerInterface $entityManager,$id): Response
    {
        # get projet par id
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProjetType::class, $project);

        # envoie vers le twig
        return $this->render('admin/Project/viewProject.html.twig',['project'=>$project,"form" => $form->createView()]);
    }


}