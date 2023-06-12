<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Service\ProgramDuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/{slug}', name: 'list')]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id found in program\'s table.'
            );
        }
        return $this->render('program/list.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program)
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
    public function new(Request $request, ProgramRepository $programRepository, RequestStack $requestStack, SluggerInterface $slugger) : Response
    {

        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $slug = $slugger->slug($program->getName());
            $program->setSlug($slug);
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