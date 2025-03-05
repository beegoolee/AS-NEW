<?php

namespace App\Helpers;

use App\Entity\ProductReview;
use Doctrine\ORM\EntityManagerInterface;

class ProductReviewsHelper
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /*
     * Обновление рейтинга товаров на основании оставленных на них отзывов
     * */
    public function updateProductsRating()
    {
        $productReviewsRepo = $this->entityManager->getRepository(ProductReview::class);
        $arProductsReviews = $productReviewsRepo->findAll();

        $arReviewedProducts = [];
        foreach ($arProductsReviews as $productReview) {
            $arReviewedProducts[$productReview->getProduct()->getId()]['PRODUCT'] = $productReview->getProduct();
            $arReviewedProducts[$productReview->getProduct()->getId()]['RATINGS'][] = $productReview->getRating();
        }

        foreach ($arReviewedProducts as $productData) {
            $iProductRating = round(array_sum($productData['RATINGS']) / count($productData['RATINGS']));
            $productData['PRODUCT']->setRating($iProductRating);
            $this->entityManager->persist($productData['PRODUCT']);
        }
        $this->entityManager->flush();
    }
}