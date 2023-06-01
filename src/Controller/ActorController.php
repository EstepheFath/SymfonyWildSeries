<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
#[Route('/{id<^[0-9]+$>}', name: 'show')]
public function show(int $actorId, int $programId): Response
    {
        $actor = $actorId->findOneBy(['actorid' => $actorId]);
        $programs = $programId->findBy(['actor' => $actor]);

        return $this->render('program/list.html.twig',
        [
            'actor' => $actorid,
            'programs' => $programs,
            ]);
    }
}