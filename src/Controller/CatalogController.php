<?php

namespace App\Controller;

use App\Entity\CatalogSection;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\ElasticsearchProductsHelper;

class CatalogController extends AbstractController
{
    private const CATALOG_PAGE_SIZE_DEFAULT = 9;

    #[Route('/api/catalog/', name: 'api_catalog', methods: ['GET'])]
    public function getCatalog(EntityManagerInterface $em, Request $request, ElasticsearchProductsHelper $eph): JsonResponse
    {
        try {
            $arReturn = [];

            // параметры для пагинации
            $iPageSize = intval($request->query->get('pagesize')) > 0 ? intval($request->query->get('pagesize')) : self::CATALOG_PAGE_SIZE_DEFAULT;
            $iPageN = intval($request->query->get('pagen')) > 0 ? intval($request->query->get('pagen')) : 1;

            $url = urldecode($request->query->get('requestedUrl')) ?? '/catalog/';

            if ($url && $url != '/catalog/') {
                // есть адрес раздела ИЛИ товара, определяем чей адрес. Сначала разделы - их априори меньше
                //TODO сджоинить обе таблицы разделов и продуктов в одну и найти по полю URL нужную сущность, от того плясать далее
                $sectionsRepo = $em->getRepository(CatalogSection::class);
                $query = $sectionsRepo->createQueryBuilder('sections')->setParameter('url', $url)->andWhere('sections.url = :url')->getQuery();
                $arSections = $query->getArrayResult();

                // если с таким урлом нашли РАЗДЕЛ
                $arCurSection = current($arSections);
                if (!empty($arCurSection)) {
                    // получаем товары данного раздела

                    // TODO переделать на join или метод из репо
                    $sSqlQuery = "SELECT product_id FROM product_catalog_section WHERE catalog_section_id = {$arCurSection["id"]}";
                    $arSectionProductsResult = $em->getConnection()->prepare($sSqlQuery)->executeQuery()->fetchAllAssociative();
                    $arSectionProductIDs = [];
                    foreach ($arSectionProductsResult as $arSectionProduct) {
                        $arSectionProductIDs[] = $arSectionProduct["product_id"];
                    }

                    $productsRepo = $em->getRepository(Product::class);
                    $productsQuery = $productsRepo->createQueryBuilder('products')
                        ->setParameter('sectionProductsIds', $arSectionProductIDs)
                        ->andWhere('products.id IN (:sectionProductsIds)')
                        ->getQuery();

                    $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($productsQuery);
                    $productsQuery = $paginator->getQuery()->setFirstResult(($iPageN - 1) * $iPageSize)->setMaxResults($iPageSize);
                    $arProducts = $productsQuery->getArrayResult();

                    $arReturn = [
                        'sections' => $arSections,
                        'products' => $arProducts,
                        'pageType' => 'section',
                        'pageTitle' => "Заголовок подраздела",
                        'pagenInfo' => [
                            'totalCount' => $paginator->count(),
                            'currentPage' => $iPageN,
                            'pageSize' => $iPageSize,
                            'currentPageCount' => count($arProducts),
                            'pagesCount' => ceil($paginator->count() / $iPageSize),
                        ]
                    ];
                } else {
                    // это не раздел - пытаемся найти деталку товара
                    $productsRepo = $em->getRepository(Product::class);
                    $query = $productsRepo->createQueryBuilder('products')->setParameter('url', $url)->andWhere('products.url = :url')->getQuery();
                    $oProduct = $query->getOneOrNullResult();
                    // если с таким урлом нашли ТОВАР
                    if ($oProduct) {
                        $arProduct = $oProduct->productDetailProps();
                        $arReturn = [
                            'products' => [
                                $arProduct
                            ],
                            'pageType' => 'product',
                            'pageTitle' => $arProduct['name']
                        ];

                        $user = $this->getUser();
                        if($user){
                            $user->addRecentlyViewedProduct($oProduct);
                            $em->persist($user);
                            $em->flush();
                        }
                    } else {
                        // ничего не нашли, 404, возвращаем пустой arReturn по-умолчанию
                    }
                }
            } else if ($url === '/catalog/') {
                // урла не пришло, возвращаем весь каталог

                $sSearchQuery = $request->query->get('search');
                if ($sSearchQuery) {
                    $arElasticResult = $eph->searchProductByName($sSearchQuery);
                    $arFilteredProductIDs = [];
                    array_map(function ($arProduct) use (&$arFilteredProductIDs) {
                        $arFilteredProductIDs[] = $arProduct["product_id"];
                    }, $arElasticResult);
                }

                // получаем все разделы
                $sectionsRepo = $em->getRepository(CatalogSection::class);
                $sectionsQuery = $sectionsRepo->createQueryBuilder('sections')->getQuery();
                $arSections = $sectionsQuery->getArrayResult();

                // получаем товары
                $productsRepo = $em->getRepository(Product::class);

                if (isset($arFilteredProductIDs)) {
                    $productsQuery = $productsRepo->createQueryBuilder('products')->setParameter('ids', $arFilteredProductIDs)->andWhere('products.id IN (:ids)')->getQuery();
                } else {
                    $productsQuery = $productsRepo->createQueryBuilder('products')->getQuery();
                }

                $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($productsQuery);
                $productsQuery = $paginator->getQuery()->setFirstResult(($iPageN - 1) * $iPageSize)->setMaxResults($iPageSize);
                $arProducts = $productsQuery->getArrayResult();

                $arReturn = [
                    'sections' => $arSections,
                    'products' => $arProducts,
                    'pageType' => 'catalog',
                    'pageTitle' => "Заголовок всего каталога",
                    'pagenInfo' => [
                        'totalCount' => $paginator->count(),
                        'currentPage' => $iPageN,
                        'pageSize' => $iPageSize,
                        'currentPageCount' => count($arProducts),
                        'pagesCount' => ceil($paginator->count() / $iPageSize),
                    ]
                ];
            }

            return $this->json($arReturn);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()]);
        }
    }

    #[Route('/api/catalog_menu/', name: 'api_catalog_menu', methods: ['GET'])]
    public function getCatalogMenu(EntityManagerInterface $em): JsonResponse
    {
        try {
            $sectionRepo = $em->getRepository(CatalogSection::class);
            $arSections = $sectionRepo->createQueryBuilder('sections')->getQuery()->getArrayResult();

            return $this->json($arSections);
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()]);
        }
    }
}
