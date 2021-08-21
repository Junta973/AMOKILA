<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TeamManagementController extends AbstractController
{
    /**
     * @Route("/admin/TeamManagement", name="app_admin_team_management")
     */
    public function index(Request $request,UserRepository $userRepository): Response
    {

        $email = $request->request->get('email');
        $skills = $request->request->get('skills');
        $level = $request->request->get('level');
        $profession = $request->request->get('profession');

        $users = $userRepository->search($email,$skills,$level,$profession);
        return $this->render('admin/TeamManagement/index.html.twig', [
            'title' => 'TEAM MANAGEMENT',
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/utitlisateur/ajouter", name="app_admin_utilisateur_ajouter", methods={"GET","POST"})
     */
    public function ajouterUtitlisateur(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Utilisateur ajouté avec succès!');
            return $this->redirectToRoute('app_admin_team_management');
        }
        return $this->render("admin/TeamManagement/addMember.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/utitlisateur/modifier/{id}", name="app_admin_utilisateur_modifier", methods={"GET","POST"})
     */
    public function modifierUtitlisateur(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Utilisateur modifié avec succès!');
            return $this->redirectToRoute('app_admin_team_management');
        }
        return $this->render("admin/TeamManagement/editMember.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/admin/utitlisateur/delete/{id}", name="app_admin_utilisateur_delete", methods={"GET"})
     */
    public function deleteUtitlisateur(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        if($user){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success','Utilisateur supprimé avec succès!');
        }else{
            $this->addFlash('danger','Utilisateur introuvable!');
        }

        return $this->redirectToRoute('app_admin_team_management');

    }

}