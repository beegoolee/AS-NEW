<?php

namespace App\Controller;

use App\Entity\CatalogSection;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CatalogController extends AbstractController
{
    #[Route('/api/catalog/{url}', name: 'api_catalog', methods: ['GET'], requirements: ["url" => ".+"])]
    public function getCatalog(EntityManagerInterface $em, $url = null): JsonResponse
    {
        $arReturn = [];

        // параметры для пагинации
        $iPageSize = 24;
        $iPageN = 1;

        if ($url && $url != '/catalog/') {
            // есть адрес раздела ИЛИ товара, определяем чей адрес. Сначала разделы - их априори меньше
            $sectionsRepo = $em->getRepository(CatalogSection::class);
            $query = $sectionsRepo->createQueryBuilder('sections')->setParameter('url', $url)->andWhere('sections.url = :url')->getQuery();
            $arSections = $query->getArrayResult();

            // если с таким урлом нашли РАЗДЕЛ
            $arCurSection = current($arSections);
            if (!empty($arCurSection)) {
                // получаем товары данного раздела

                $arObProducts = $sectionsRepo->find($arCurSection['id'])->getProducts()->getValues();
                $arProducts = [];
                foreach ($arObProducts as $product) {
                    $arProducts[] = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'url' => $product->getUrl(),
                        'image' => $product->getImage(),
                        'price' => $product->getPrice(),
                        'rating' => $product->getRating(),
                        'slug' => $product->getSlug(),
                    ];
                }
//                TODO Надо переделать на query builder с применением пагинации
//                $productsRepo = $em->getRepository(Product::class);
//                $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($productsQuery);
//                $productsQuery = $paginator->getQuery()->setFirstResult(($iPageN - 1) * $iPageSize)->setMaxResults($iPageSize);
//                $arProducts = $productsQuery->getArrayResult();


                $arReturn = [
                    'sections' => $arSections,
                    'products' => $arProducts,
                    'pageType' => 'section'
                ];
            } else {
                // это не раздел - пытаемся найти деталку товара
                $productsRepo = $em->getRepository(Product::class);
                $query = $productsRepo->createQueryBuilder('products')->setParameter('url', $url)->andWhere('products.url = :url')->getQuery();
                $arProducts = $query->getArrayResult();

                // если с таким урлом нашли ТОВАР
                $arCurProduct = current($arProducts);
                if (!empty($arCurProduct)) {
                    $arReturn = [
                        'products' => $arProducts,
                        'pageType' => 'product'
                    ];
                } else {
                    // ничего не нашли, 404, возвращаем пустой arReturn по-умолчанию
                }
            }
        } else if ($url === '/catalog/') {
            // урла не пришло, возвращаем весь каталог

            // получаем все разделы
            $sectionsRepo = $em->getRepository(CatalogSection::class);
            $sectionsQuery = $sectionsRepo->createQueryBuilder('sections')->getQuery();
            $arSections = $sectionsQuery->getArrayResult();

            // получаем товары
            $productsRepo = $em->getRepository(Product::class);
            $productsQuery = $productsRepo->createQueryBuilder('products')->getQuery();
            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($productsQuery);
            $productsQuery = $paginator->getQuery()->setFirstResult(($iPageN - 1) * $iPageSize)->setMaxResults($iPageSize);
            $arProducts = $productsQuery->getArrayResult();

            $arReturn = [
                'sections' => $arSections,
                'products' => $arProducts,
                'pageType' => 'catalog'
            ];
        }

        return $this->json($arReturn);
    }

    #[Route('/api/catalog_menu/', name: 'api_catalog_menu', methods: ['GET'])]
    public function getCatalogMenu(EntityManagerInterface $em): JsonResponse
    {
        $sectionRepo = $em->getRepository(CatalogSection::class);
        $arSections = $sectionRepo->createQueryBuilder('sections')->getQuery()->getArrayResult();

        return $this->json($arSections);
    }
}
