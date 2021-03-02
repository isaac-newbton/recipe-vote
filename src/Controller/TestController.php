<?php

namespace App\Controller;

use App\Entity\MediaFile;
use App\Form\MediaFileType;
use App\Repository\MediaFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class TestController extends AbstractController {
    /**
     * @Route("/uploadtest", name="uploadtest")
     */
    public function uploadtest(Request $request, SluggerInterface $slugger) : Response {
        $mediaFile = new MediaFile();
        $form = $this->createForm(MediaFileType::class, $mediaFile);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            if($file){
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                $path = $this->getParameter('app.mediafiles_base_directory') . DIRECTORY_SEPARATOR . (string)date('Y') . DIRECTORY_SEPARATOR . (string)date('m');
                $mimeType = $file->getMimeType();
                try{
                    $file->move(
                        $this->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $path,
                        $newFilename
                    );
                }catch(FileException $e){

                }
                $mediaFile->setPath($path . DIRECTORY_SEPARATOR . $newFilename);
                $mediaFile->setName($newFilename);
                $mediaFile->setMimeType($mimeType);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($mediaFile);
                $manager->flush();
            }
            return $this->redirectToRoute('mediafilestest');
        }
        return $this->render('test/uploadtest.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/mediafilestest", name="mediafilestest")
     */
    public function mediafilestest(MediaFileRepository $mediaFileRepository) : Response {
        return $this->render('test/mediafilestest.html.twig', [
            'files'=>$mediaFileRepository->findAll()
        ]);
    }
}