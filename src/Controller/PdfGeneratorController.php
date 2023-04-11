<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator', name: 'app_pdf_generator')]
    public function index(): Response
    {
       /* return $this->render('pdf_generator/index.html.twig', [
            'controller_name' => 'PdfGeneratorController',
        ]); */

        $data = [
            
       
            
            'name'         => 'Pepe Pedrosae',
            'address'      => 'Portugal',
            'mobileNumber' => '000000000',
            'email'        => 'john.doe@email.com'
        ];
        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
         
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

 
}
