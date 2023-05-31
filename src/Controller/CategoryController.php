<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categorys = $categoryRepository->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categorys' => $categorys]
        );
    }

    #[Route('/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $id]);
        $programs = $programRepository->findBy(['category' => $category->getId()],
        ['id' => 'DESC']);

        if (!$category) {
            throw $this->createNotFoundException(
                "No category with id : ' . $id . ' found' in program's table"
            );
        }
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
            ]);

    }
}