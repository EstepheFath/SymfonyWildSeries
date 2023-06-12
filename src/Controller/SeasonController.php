<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/season', name: 'season_')]
class SeasonController extends AbstractController
{

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    #[Route('/{id<^[0-9]+$>}', name: 'season')]
    public function index(int $id, SeasonRepository $seasonRepository)
    {

        $seasons = $seasonRepository->findOneBy(['id'=> $id]);

        return $this->render(
            'season_show.html.twig',
            ['seasons' => $seasons]
        );
    }
}