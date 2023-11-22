<?php

namespace App\Controller;

use App\Service\SlugService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function listProducts(): Response
    {
        return $this->render('product/index.html.twig', [
        ]);
    }

    #[Route('/product/slug', name: 'product_slug')]
    public function slugProductName(SlugService $slugService): Response
    {
        $slug = $slugService->generateSlug("l'histoire des choses 2023 àé&é");

        return $this->render('product/slug.html.twig', [
            'slug' => $slug
        ]);
    }

    #[Route('/product/{id}', name: 'product_detail')]
    public function viewProduct(int $id): Response
    {
        return $this->render('product/product.html.twig', [
            'id' => $id,
        ]);
    }
}
