<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductsController extends AbstractController
{
    #[Route('/api/product/{slug}', name: 'api_products', methods: ['GET'])]
    public function getProduct(ProductRepository $productRepository, $slug): JsonResponse
    {
        header('Access-Control-Allow-Origin: *');

        // конкретный товар
        $return = $productRepository->createQueryBuilder('products')->setParameter('slug', $slug)->andWhere('products.slug = :slug')->getQuery()->getArrayResult();

        return $this->json($return);
    }
}
