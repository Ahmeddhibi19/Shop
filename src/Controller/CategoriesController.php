<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function list(string $slug, ProductsRepository $productsRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(Categories::class)->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('category not found');
        }

        //On va chercher le numéro de page dans l'url
        $page = $request->query->getInt('page', 1);

        //On va chercher la liste des produits de la catégorie
        $products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 4);
        
        return $this->render('categories/list.html.twig', compact('category', 'products'));
        // Syntaxe alternative
        // return $this->render('categories/list.html.twig', [
        //     'category' => $category,
        //     'products' => $products
        // ]);
    }
}