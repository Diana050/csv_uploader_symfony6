<?php

namespace App\Controller;

use App\Entity\CsvFiles;
use App\Form\CsvFileUploadType;
use App\Message\CsvAddFile;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\Statement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use League\Csv\Reader;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function upload(Request $request, SluggerInterface $slugger,  EntityManagerInterface $db, MessageBusInterface $bus): Response
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
                    $CsvFile->setCsvFileName($newFilename);

                    $csv = Reader::createFromPath("/app/public/uploads/CsvFile/$newFilename");

                    $stmt = Statement::create()
                        ->offset(0)
                    ;

                    $records = $stmt->process($csv);

                    foreach ($records as $row) {
                        $bus->dispatch(new CsvAddFile($row[1], $row[2], $row[3]));
                    }

                } catch (FileException $e) {
                    dd($e->getMessage());
                    // ... handle exception if something happens during file upload
                } catch (Exception $e) {
                    dd($e->getMessage());
                }


            }

            return $this->redirectToRoute('app_home');
        }
            return $this->renderForm('home/index.html.twig', [
                'form' => $form,
            ]);

        }

}

