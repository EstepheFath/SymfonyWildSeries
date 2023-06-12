<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Flex\Response;


#[Route('/category', name: 'category')]
class CategoryTypeController extends AbstractController
{
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    // src/Controller/CategoryController.php
    //...

    /**
     * The controller for the category add form
     * Display the form or deal with it
     */
    #[Route('/form', name: 'formcategory')]
    public function new(Request $request, CategoryRepository $categoryRepository) : \Symfony\Component\HttpFoundation\Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->render('form/category.html.twig', [
            'form' => $form,
        ]);
    }
}