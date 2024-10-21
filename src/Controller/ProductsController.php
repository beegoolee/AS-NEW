<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductsController extends AbstractController
{
    #[Route('/api/products/{slug}', name: 'api_products', methods: ['GET'])]
    public function getProducts(ProductRepository $productRepository, $slug = null): JsonResponse
    {
        header('Access-Control-Allow-Origin: *');

        if($slug){
            $return = $productRepository->createQueryBuilder('products')->setParameter('slug', $slug)->andWhere('products.slug = :slug')->getQuery()->getArrayResult();
        }else{
            $return = $productRepository->createQueryBuilder('products')->getQuery()->getArrayResult();
        }

        return $this->json($return);
    }
}
