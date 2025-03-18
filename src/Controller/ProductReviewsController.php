<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductReview;
use App\Helpers\ProductReviewsHelper;
use App\Repository\ProductReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProductReviewsController extends AbstractController
{
    #[Route('/api/product_review/add/', name: 'add_product_review', methods: ['POST'])]
    public function addProductReview(EntityManagerInterface $em, Request $request, ProductReviewsHelper $prh): JsonResponse
    {
        $arRequest = $request->toArray();

        $productReview = new ProductReview();

        $productReview->setUser($this->getUser());
        $productReview->setRating($arRequest['rating']);

        $productRepo = $em->getRepository(Product::class);
        $reviewedProduct = $productRepo->findOneBy(['id' => $arRequest['product_id']]);

        $productReview->setProduct($reviewedProduct);
        $productReview->setText($arRequest['text']);
        $em->persist($productReview);
        $em->flush();
        $prh->updateProductsRating($arRequest['product_id']); // TODO сделать ивент, при добавлении отзыва - пересчет оценки товара

        return $this->json(['success' => true]);
    }
    #[Route('/api/product_review/get/{product}', name: 'get_product_reviews', methods: ['GET'])]
    public function getProductReviews(Product $product): JsonResponse
    {
        $arProductReviews = $product->getProductReviews()->toArray();

        $arReturn = [];
        foreach ($arProductReviews as $obProductReview) {
            $arReturn[] = [
              'id' => $obProductReview->getId(),
              'rating' => $obProductReview->getRating(),
              'text' => $obProductReview->getText(),
              'userId' => $obProductReview->getUser()->getId(),
              'userName' => $obProductReview->getUser()->getUserIdentifier(),
            ];
        }

        return $this->json($arReturn);
    }
}
