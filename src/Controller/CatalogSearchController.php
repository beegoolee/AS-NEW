<?php

namespace App\Controller;

use App\Helpers\ElasticsearchProductsHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CatalogSearchController extends AbstractController
{
    #[Route('/api/product_search/{searchText}', name: 'search_product', methods: ['GET'])]
    public function findProductsByName(ElasticsearchProductsHelper $eph, string $searchText): JsonResponse
    {
        $search = $eph->searchProductByName($searchText);

        return $this->json($search);
    }
}
