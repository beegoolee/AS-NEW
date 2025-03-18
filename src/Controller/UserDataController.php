<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Enums\OrderStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserDataController extends AbstractController
{
    #[Route('/api/delete_user_recent_products/', name: 'delete_user_recent_products', methods: ['DELETE'])]
    public function deleteUserRecentlyViewed(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user) {
            $user->clearRecentlyViewedProduct();
            $em->persist($user);
            $em->flush();
            return $this->json(['success' => true]);
        } else {
            return $this->json(['success' => false, 'message' => 'User undefiend']);
        }

    }

    #[Route('/api/was_product_bought_by_user/{product}', name: 'was_product_bought_by_user', methods: ['GET'])]
    public function getWasProductBoughtByUser(Product $product, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user) {
            $userOrders = $em->getRepository(Order::class)->findBy(['User' => $user, 'Status' => OrderStatusEnum::Success]); // TODO проверить. СДелать заказ, выставить статус "выполнен"
            $isProductRecentlyBought = false;
            foreach ($userOrders as $order) {
                if($isProductRecentlyBought) break;
                foreach ($order->getOrderProducts()->getProducts() as $orderProduct) {
                    if($product->getId() == $orderProduct['product_id']){
                        $isProductRecentlyBought = true;
                        break;
                    }
                }
            }

            return $this->json(['was_bought' => $isProductRecentlyBought]);
        }
        return $this->json(['was_bought' => false]);
    }

    #[Route('/api/get_user_recent_products/', name: 'get_user_recent_products', methods: ['GET'])]
    public function getUserRecentlyViewed()
    {
        $arReturn = [];
        $user = $this->getUser();
        if ($user) {
            $arRecentlyProducts = $user->getRecentlyViewedProduct();
            foreach ($arRecentlyProducts as $item) {
                $arReturn[] = $item->productDetailProps();
            }
        }
        return $this->json($arReturn);
    }

    #[Route('/api/user/is_authorized/', name: 'user_is_authorized', methods: ['GET'])]
    public function userIsAuthorized(): JsonResponse
    {
        try {
            return $this->json(
                [
                    'is_authorized' => $this->isGranted('IS_AUTHENTICATED_FULLY'),
                    'username' => $this->getUser()?->getUserIdentifier(),
                ]
            );
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }
}
