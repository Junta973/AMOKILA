<?php

namespace App\Controller\admin;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterialController extends AbstractController
{
    /**
     * @Route("/admin/material", name="app_admin_material")
     */
    public function index(Request $request,MaterialRepository $materialRepository): Response
    {

        $ref = $request->request->get('ref');
        $name = $request->request->get('name');
        $etat = $request->request->get('etat');


        $allMaterials = $materialRepository->search($ref,$name,$etat);
        return $this->render('admin/Material/index.html.twig', [
            'title' => 'MATERIALS LIST',
            'allMaterials' => $allMaterials
        ]);
    }

    /**
     * @route("/admin/material/ajouter", name="app_admin_material_ajouter", methods={"GET","POST"})
     */
    public function ajouterMaterial(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $material = $form->getData();
            $entityManager->persist($material);
            $entityManager->flush();
            $this->addFlash('success','Material ajouter avec succès!');
            return $this->redirectToRoute('app_admin_material');
        }
        return $this->render('admin/Material/ajouterMaterial.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @route("/admin/material/modifier/{id}", name="app_admin_material_modifier", methods={"GET","POST"})
     */
    public function modifierMaterial(Request $request,MaterialRepository $materialRepository,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $materila = $materialRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(MaterialType::class, $materila);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $material = $form->getData();
            $entityManager->persist($material);
            $entityManager->flush();
            $this->addFlash('success','Material modifié avec succès!');
            return $this->redirectToRoute('app_admin_material');
        }
        return $this->render('admin/Material/modifierMaterial.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/material/delete/{id}", name="app_admin_material_delete", methods={"GET"})
     */
    public function deleteMaterial(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Material = $entityManager->getRepository(Material::class)->findOneBy(['id'=>$id]);
        if($Material){
            $entityManager->remove($Material);
            $entityManager->flush();
            $this->addFlash('success','Material supprimé avec succès!');
        }else{
            $this->addFlash('danger','Material introuvable!');
        }

        return $this->redirectToRoute('app_admin_material');

    }

    /**
     * @route("/admin/process/view/{id}", name="app_admin_material_view", methods={"GET"})
     */
    public function viewMaterial(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Material = $entityManager->getRepository(Material::class)->findOneBy(['id'=>$id]);
        return $this->render('admin/Material/viewMaterial.html.twig',['material'=>$Material]);
    }
}