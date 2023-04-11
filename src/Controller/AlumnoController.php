<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use DateTime;

#[Route('/alumno')]
class AlumnoController extends AbstractController
{
    #[Route('/', name: 'app_alumno_index', methods: ['GET'])]
    public function index(AlumnoRepository $alumnoRepository): Response
    {
        return $this->render('alumno/index.html.twig', [
            'alumnos' => $alumnoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_alumno_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AlumnoRepository $alumnoRepository): Response
    {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('app_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('alumno/new.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_alumno_show', methods: ['GET'])]
    public function show(Alumno $alumno): Response
    {
        return $this->render('alumno/show.html.twig', [
            'alumno' => $alumno,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_alumno_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('app_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('alumno/edit.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
        ]);
    }

//generar pdf:


#[Route('/{id}/pdfgen', name: 'app_alumno_pdfgen', methods: ['GET', 'POST'])]
public function pdfgen(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
{

   
    $FechaInfo= new DateTime();

    $data = [
        'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/images/sf.png'),
        'name'         =>$alumno->getName(),
        'surname'      => $alumno->getSurname(),
        'FechaReg'      => $alumno->getDatereg(),
        'centro'      => $alumno->getColegio()
      
        
    ];
 
    $html =  $this->renderView('alumno/pdfalumno.html.twig', $data);
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->render();
     
    return new Response (
        $dompdf->stream('resume', ["Attachment" => false]),
        Response::HTTP_OK,
        ['Content-Type' => 'application/pdf']
    );

}

private function imageToBase64($path) {
    $path = $path;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}



    #[Route('/{id}', name: 'app_alumno_delete', methods: ['POST'])]
    public function delete(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alumno->getId(), $request->request->get('_token'))) {
            $alumnoRepository->remove($alumno, true);
        }

        return $this->redirectToRoute('app_alumno_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
