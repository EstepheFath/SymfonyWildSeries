<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/{id<^[0-9]+$>}', name: 'list')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/list.html.twig', [
            'program' => $program,
        ]);
    }

#[Route('/program/{programId}/seasons/{seasonId}', name: 'program_season_show')]
    public function showSeason(int $programId, int $seasonId)
    {
        $program = $programId->findOneBy(['programId' => $programId]);
        $season = $seasonId->findOneBy(['saisonId' => $seasonId]);

        return $this->render('templates/program/season_show.html.twig',[
            'program' => $program,
            'season' => $season,
        ]);
    }

    /**
     * The controller for the category add form
     * Display the form or deal with it
     */
    #[Route('/form', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, RequestStack $requestStack) : Response
    {

        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($program, true);
            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('form/program.html.twig', [
            'form' => $form,
        ]);
    }
}