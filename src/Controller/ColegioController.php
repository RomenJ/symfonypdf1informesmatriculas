<?php

namespace App\Controller;

use App\Entity\Colegio;
use App\Form\ColegioType;
use App\Repository\ColegioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/colegio')]
class ColegioController extends AbstractController
{
    #[Route('/', name: 'app_colegio_index', methods: ['GET'])]
    public function index(ColegioRepository $colegioRepository): Response
    {
        return $this->render('colegio/index.html.twig', [
            'colegios' => $colegioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_colegio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ColegioRepository $colegioRepository): Response
    {
        $colegio = new Colegio();
        $form = $this->createForm(ColegioType::class, $colegio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colegioRepository->save($colegio, true);

            return $this->redirectToRoute('app_colegio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colegio/new.html.twig', [
            'colegio' => $colegio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colegio_show', methods: ['GET'])]
    public function show(Colegio $colegio): Response
    {
        return $this->render('colegio/show.html.twig', [
            'colegio' => $colegio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_colegio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Colegio $colegio, ColegioRepository $colegioRepository): Response
    {
        $form = $this->createForm(ColegioType::class, $colegio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $colegioRepository->save($colegio, true);

            return $this->redirectToRoute('app_colegio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('colegio/edit.html.twig', [
            'colegio' => $colegio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_colegio_delete', methods: ['POST'])]
    public function delete(Request $request, Colegio $colegio, ColegioRepository $colegioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$colegio->getId(), $request->request->get('_token'))) {
            $colegioRepository->remove($colegio, true);
        }

        return $this->redirectToRoute('app_colegio_index', [], Response::HTTP_SEE_OTHER);
    }
}
