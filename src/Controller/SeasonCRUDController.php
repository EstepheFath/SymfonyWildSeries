<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/season/c/r/u/d')]
class SeasonCRUDController extends AbstractController
{
    #[Route('/', name: 'app_season_c_r_u_d_index', methods: ['GET'])]
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('season_crud/index.html.twig', [
            'seasons' => $seasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_season_c_r_u_d_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeasonRepository $seasonRepository, MailerInterface $mailer): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->save($season, true);

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Season/newSeasonEmail.html.twig', ['season' => $season]));

            $mailer->send($email);
            $this->getParameter('mailer_from');
            return $this->redirectToRoute('app_season_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('season_crud/new.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_season_c_r_u_d_show', methods: ['GET'])]
    public function show(Season $season): Response
    {
        return $this->render('season_crud/show.html.twig', [
            'season' => $season,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_season_c_r_u_d_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Season $season, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->save($season, true);

            return $this->redirectToRoute('app_season_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('season_crud/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_season_c_r_u_d_delete', methods: ['POST'])]
    public function delete(Request $request, Season $season, SeasonRepository $seasonRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();

        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->request->get('_token'))) {
            $seasonRepository->remove($season, true);
        }

        $this->addFlash('success', 'The season has been deleted.');

        return $this->redirectToRoute('app_season_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
    }
}
