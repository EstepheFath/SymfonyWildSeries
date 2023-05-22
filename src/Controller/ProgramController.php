<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{

    #[Route('/', name: 'program_index')]
    public function index(): Response
    {
        return $this->render('program.html.twig', [
            'website' => 'Wild Series',
        ]);
    }

    #[Route('/list/{page}',  name: 'list', requirements: ['page'=>'\d+'], methods: ['GET'])]
    public function list(int $page): Response
    {
        return $this->render('program/list.html.twig', ['page' => $page]);
    }
}