<?php

namespace App\Controller;

use App\Repository\CatalogSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SectionController extends AbstractController
{
    #[Route('/api/sections/{slug}', name: 'api_sections', methods: ['GET'])]
    public function getSection(CatalogSectionRepository $catalogSectionRepository, $slug = null): JsonResponse
    {
        header('Access-Control-Allow-Origin: *');

        if ($slug) {
            // конкретный раздел
            $query = $catalogSectionRepository->createQueryBuilder('sections')->setParameter('slug', $slug)->andWhere('sections.slug = :slug')->getQuery();
        } else {
            // весь каталог
            $query = $catalogSectionRepository->createQueryBuilder('sections')->getQuery();
        }

//        $iPageSize = 24;
//        $iPageN = 1;
//
//        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
//        $query = $paginator->getQuery()->setFirstResult(($iPageN - 1) * $iPageSize)->setMaxResults($iPageSize);

        $arSections = $query->getArrayResult();

        return $this->json($arSections);
    }
}
