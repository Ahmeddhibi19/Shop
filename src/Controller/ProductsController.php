<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/{slug}', name: 'details')]
    public function details(string $slug, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Products::class)->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->render('products/details.html.twig',compact('product'));
    }
}