<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
    #[Route('/program/{programId}/season/{seasonId}/episode/{episodeId}', name: 'program_episode_show')]
    #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]
    #[Entity('comment', options: ['mapping' => ['season_id' => 'id']])]
    #[Entity('episode', options: ['mapping' => ['episode_id' => 'id']])]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('episode.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' =>$episode,
        ]);
    }
}