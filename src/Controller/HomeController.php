<?php

namespace App\Controller;

use App\Entity\CsvFiles;
use App\Form\CsvFileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function upload(Request $request, SluggerInterface $slugger)
    {
        $CsvFile = new CsvFiles();
        $form = $this->createForm(CsvFileUploadType::class, $CsvFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $File */
            $File = $form->get('CsvFileName')->getData();

            if ($File) {
                $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $File->guessExtension();

                try {
                    $File->move(
                        $this->getParameter('CsvFiles_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $CsvFile->setCsvFileName($newFilename);
            }

            return $this->redirectToRoute('app_home');
        }
            return $this->renderForm('home/index.html.twig', [
                'form' => $form,
            ]);

        }

}

