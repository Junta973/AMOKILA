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

    # la route de la page dashboard
    ## L'annotation : le path et le nom de route Exemple "/admin" , name = "app_admin"
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(
        ProjectRepository $projectRepository,
        ProjectChangeRequestRepository $changeRequestRepository,
        ProcessRepository $processRepository,
        TaskRepository $taskRepository,
        MaterialRepository $materialRepository
    )
    {
        # Si l'utilisateur connecté n'a pas le rôle admin on va le rediriger vers la page liste de projet
        if ($this->isGranted("ROLE_ADMIN") != true)
            return $this->redirectToRoute('app_admin_project');

        # Le nombre de projets total de la base de données
        $totalProject = $projectRepository->getNbrResults();
        # Le nbr(parameter) dernier resultats
        $lastProjects = $projectRepository->getLastResluts(5);

        # Le nombre de change requests  total de la base de données
        $totalPCR = $changeRequestRepository->getNbrResults();
        # Le nbr(parameter) dernier resultats
        $lastPCRs = $changeRequestRepository->getLastResluts(5);

        # Le nombre de process  total de la base de données
        $totalProcess = $processRepository->getNbrResults();
        # Le nbr(parameter) dernier resultats
        $lastProcess = $processRepository->getLastResluts(5);

        # Le nombre de tasks  total de la base de données
        $totalTasks = $taskRepository->getNbrResults();
        # Le nbr(parameter) dernier resultats
        $lastTasks = $taskRepository->getLastResluts(5);

        # Le nbr(parameter) dernier task in progress
        $lastTasksInProgress = $taskRepository->getLastTaskOnProgress(5);


        # Le nombre de change requests selon status
        $nbrPCRApprouved = $changeRequestRepository->getNbrResultsByStats('Approuved');
        $nbrPCRNewCR = $changeRequestRepository->getNbrResultsByStats('New CR');
        $nbrPCRInReview = $changeRequestRepository->getNbrResultsByStats('In Review');
        $nbrPCRRejected = $changeRequestRepository->getNbrResultsByStats('Rejected');

        # On utilise la fonction count pour selectionner le nombre total de materiels
        $materialCount = $materialRepository->count([]);
        # le nombre de materiels valide
        $materialValid = $materialRepository->countValide();

        # On pass tout les variable vers le twig
        return $this->render('admin/dashboard.html.twig', [
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

    # La route de la page modifier profile
    /**
     * @Route("/admin/profile", name="app_admin_profile_modifier")
     */
    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder,SluggerInterface $slugger,EntityManagerInterface $entityManager)
    {
        # permet de d'avoir l'utilisateur connecté
        $user = $this->getUser();

        # creation de formulaire
        $form = $this->createForm(profileType::class, $user);


        # Traiter les données du formulaire + verification
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

            # le cryptage du mot de pass est défini en auto voir le fichier security.yaml
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            # persist et le flush
            $entityManager->persist($user);
            $entityManager->flush();

            # le message d'alert
            $this->addFlash('success','Profile modifié avec succès!');

            # le redirect vers page dashboard
            return $this->redirectToRoute('app_admin');
        }

        return $this->render("admin/Profile/profile.html.twig", ["form" => $form->createView()]);
    }
}
