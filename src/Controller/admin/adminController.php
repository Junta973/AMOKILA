<?php

namespace App\Controller\admin;

use App\Form\profileType;
use App\Form\UserType;
use App\Repository\MaterialRepository;
use App\Repository\ProcessRepository;
use App\Repository\ProjectChangeRequestRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class adminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(
        ProjectRepository $projectRepository,
        ProjectChangeRequestRepository $changeRequestRepository,
        ProcessRepository $processRepository,
        TaskRepository $taskRepository,
        MaterialRepository $materialRepository
    ): Response
    {
        if ($this->isGranted("ROLE_ADMIN") != true)
            return $this->redirectToRoute('app_admin_project');

        $totalProject = $projectRepository->getNbrResults();
        $lastProjects = $projectRepository->getLastResluts(5);

        $totalPCR = $changeRequestRepository->getNbrResults();
        $lastPCRs = $changeRequestRepository->getLastResluts(5);

        $totalProcess = $processRepository->getNbrResults();
        $lastProcess = $processRepository->getLastResluts(5);

        $totalTasks = $taskRepository->getNbrResults();
        $lastTasks = $taskRepository->getLastResluts(5);

        $lastTasksInProgress = $taskRepository->getLastTaskOnProgress(5);

        $nbrPCRApprouved = $changeRequestRepository->getNbrResultsByStats('Approuved');
        $nbrPCRNewCR = $changeRequestRepository->getNbrResultsByStats('New CR');
        $nbrPCRInReview = $changeRequestRepository->getNbrResultsByStats('In Review');
        $nbrPCRRejected = $changeRequestRepository->getNbrResultsByStats('Rejected');

        $materialCount = $materialRepository->count([]);
        $materialValid = $materialRepository->countValide();


        return $this->render('admin/index.html.twig', [
            'title' => 'DASHBOARD',
            'totalProject' => $totalProject,
            'lastProjects' => $lastProjects,
            'totalPCR' => $totalPCR,
            'lastPCRs' => $lastPCRs,
            'totalProcess' => $totalProcess,
            'lastProcess' => $lastProcess,
            'totalTasks' => $totalTasks,
            'lastTasks' => $lastTasks,
            'lastTasksInProgress' => $lastTasksInProgress,

            'nbrPCRApprouved' =>$nbrPCRApprouved,
            'nbrPCRNewCR' =>$nbrPCRNewCR,
            'nbrPCRInReview' =>$nbrPCRInReview,
            'nbrPCRRejected' =>$nbrPCRRejected,

            'materialCount' => $materialCount,
            'materialValid' => $materialValid
        ]);
    }

    /**
     * @Route("/admin/profile", name="app_admin_profile_modifier", methods={"GET","POST"})
     */
    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder,SluggerInterface $slugger,EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(profileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('avatar')->getData()->getImageFile();

            // Ce test est necessaire parce que le champ 'image' n'est pas obligatoire
            // donc la requete doit être executé que si l'image est uploadé
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // permet de nettoyer le nom afin de pouvoir l'utiliser dans l'url(enleve les caractères spéciaux)
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '_' . uniqid() . '.' . $imageFile->guessExtension();

                //Déplace le fichier dans le dossier images ou uploads contenu dans le dossier publique

                $imageFile->move(
                    $this->getParameter('folder_upload_images'),
                    $newFilename
                );

                // MaJ 'imageFilename' property to store the PDF file name
                // instead of its contents
                $media =  $user->getAvatar();
                $media->setPath($newFilename);
                $user->setAvatar($media);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Profile modifié avec succès!');
            return $this->redirectToRoute('app_admin_profile_modifier');
        }
        return $this->render("admin/Profile/profile.html.twig", ["form" => $form->createView()]);
    }
}
