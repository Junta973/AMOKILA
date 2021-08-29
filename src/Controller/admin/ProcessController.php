<?php

namespace App\Controller\admin;

use App\Entity\Process;
use App\Form\ProcessType;
use App\Repository\ProcessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProcessController extends AbstractController
{
    /**
     * @Route("/admin/process", name="app_admin_process")
     */
    public function index(Request $request,ProcessRepository $processRepository): Response
    {

        $processref = $request->request->get('processref');
        $processname = $request->request->get('processname');
        $allProcess = $processRepository->search($processref,$processname);
        return $this->render('admin/Process/index.html.twig', [
            'title' => 'PROCESS',
            'allProcess' => $allProcess
        ]);
    }

    /**
     * @route("/admin/process/ajouter", name="app_admin_process_ajouter", methods={"GET","POST"})
     */
    public function ajouterProcess(Request $request,SluggerInterface $slugger,EntityManagerInterface $entityManager): Response
    {
        $process = new Process();
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $process_path = $form->get('process_path')->getData()->getImageFile();
            $document1_path = $form->get('document1_path')->getData();
            $document2_path = $form->get('document2_path')->getData();
            $document3_path = $form->get('document3_path')->getData();
            $document4_path = $form->get('document4_path')->getData();

            if ($process_path) {
                $newFilename = self::upload($slugger,$process_path);
                $mediap =  $process->getProcessPath();
                $mediap->setPath($newFilename);
                $process->setProcessPath($mediap);
            }
            if ($document1_path and $document1_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document1_path->getImageFile());
                $media1 =  $process->getDocument1Path();
                $media1->setPath($newFilename);
                $process->setDocument1Path($media1);
            }
            if ($document2_path and $document2_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document2_path->getImageFile());
                $media2 =  $process->getDocument2Path();
                $media2->setPath($newFilename);
                $process->setDocument2Path($media2);
            }
            if ($document3_path and $document3_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document3_path->getImageFile());
                $media3 =  $process->getDocument3Path();
                $media3->setPath($newFilename);
                $process->setDocument3Path($media3);
            }
            if ($document4_path and $document4_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document4_path->getImageFile());
                $media4 =  $process->getDocument4Path();
                $media4->setPath($newFilename);
                $process->setDocument4Path($media4);
            }

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
    public function modifierProcess(Request $request,ProcessRepository $processRepository,SluggerInterface $slugger,EntityManagerInterface $entityManager,$id): Response
    {
        $process = $processRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $process_path = $form->get('process_path')->getData();
            $document1_path = $form->get('document1_path')->getData();
            $document2_path = $form->get('document2_path')->getData();
            $document3_path = $form->get('document3_path')->getData();
            $document4_path = $form->get('document4_path')->getData();

            if ($process_path->getImageFile()) {
                $newFilename = self::upload($slugger,$process_path->getImageFile());
                $mediap =  $process->getProcessPath();
                $mediap->setPath($newFilename);
                $process->setProcessPath($mediap);
            }
            if ($document1_path and $document1_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document1_path->getImageFile());
                $media1 =  $process->getDocument1Path();
                $media1->setPath($newFilename);
                $process->setDocument1Path($media1);
            }
            if ($document2_path and $document2_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document2_path->getImageFile());
                $media2 =  $process->getDocument2Path();
                $media2->setPath($newFilename);
                $process->setDocument2Path($media2);
            }
            if ($document3_path and $document3_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document3_path->getImageFile());
                $media3 =  $process->getDocument3Path();
                $media3->setPath($newFilename);
                $process->setDocument3Path($media3);
            }
            if ($document4_path and $document4_path->getImageFile()) {
                $newFilename = self::upload($slugger,$document4_path->getImageFile());
                $media4 =  $process->getDocument4Path();
                $media4->setPath($newFilename);
                $process->setDocument4Path($media4);
            }

            $process = $form->getData();
            $entityManager->persist($process);
            $entityManager->flush();
            $this->addFlash('success','Process modifié avec succès!');
            return $this->redirectToRoute('app_admin_process');
        }
        return $this->render('admin/Process/modifierProcess.html.twig', ["form" => $form->createView()]);
    }

    public function upload(SluggerInterface $slugger,$file){
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '_' . uniqid() . '.' . $file->guessExtension();

        $file->move(
            $this->getParameter('folder_upload_images'),
            $newFilename
        );
        return $newFilename;
    }

    /**
     * @Route("/admin/process/delete/{id}", name="app_admin_process_delete", methods={"GET"})
     */
    public function deleteProcess(Request $request,EntityManagerInterface $entityManager, $id): Response
    {
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
    public function viewProcess(Request $request,EntityManagerInterface $entityManager,$id): Response
    {
        $process = $entityManager->getRepository(Process::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);
        return $this->render('admin/Process/viewProcess.html.twig',['process'=>$process,"form" => $form->createView()]);
    }
}