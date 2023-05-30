<?php

namespace App\Controller;

use App\Entity\Oficina;
use App\Form\OficinaType;
use App\Repository\OficinaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oficina')]
class OficinaController extends AbstractController
{
    #[Route('/', name: 'app_oficina_index', methods: ['GET'])]
    public function index(OficinaRepository $oficinaRepository): Response
    {
        return $this->render('oficina/index.html.twig', [
            'oficinas' => $oficinaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_oficina_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OficinaRepository $oficinaRepository): Response
    {
        $oficina = new Oficina();
        $form = $this->createForm(OficinaType::class, $oficina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oficinaRepository->save($oficina, true);

            return $this->redirectToRoute('app_oficina_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('oficina/new.html.twig', [
            'oficina' => $oficina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oficina_show', methods: ['GET'])]
    public function show(Oficina $oficina): Response
    {
        return $this->render('oficina/show.html.twig', [
            'oficina' => $oficina,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_oficina_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Oficina $oficina, OficinaRepository $oficinaRepository): Response
    {
        $form = $this->createForm(OficinaType::class, $oficina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oficinaRepository->save($oficina, true);

            return $this->redirectToRoute('app_oficina_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('oficina/edit.html.twig', [
            'oficina' => $oficina,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oficina_delete', methods: ['POST'])]
    public function delete(Request $request, Oficina $oficina, OficinaRepository $oficinaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oficina->getId(), $request->request->get('_token'))) {
            $oficinaRepository->remove($oficina, true);
        }

        return $this->redirectToRoute('app_oficina_index', [], Response::HTTP_SEE_OTHER);
    }
}
