<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/api/app_get_user_order_history/{userId}', name: 'app_get_user_actual_cart', methods: ['GET'])]
    public function getUserOrderHistory(User $cartOwner): JsonResponse
    {
        // получаем ВСЕ закрытые корзину (сиречь - заказы) юзера
        return $this->json([]);
    }

    #[Route('/api/app_get_user_cart/{userId}', name: 'app_get_user_actual_cart', methods: ['GET'])]
    public function getUserCart(User $cartOwner): JsonResponse
    {
        // получаем корзину юзера (актуальную, тобишь, последнюю из БД)
        return $this->json([]);
    }

    #[Route('/api/app_edit_user_cart/{userId}', name: 'app_get_user_actual_cart', methods: ['POST'])]
    public function editUserCart(User $cartOwner, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();

        // Добавляем, изменяем количество, удаляем товар из актуальной корзины юзера
        return $this->json([]);
    }
}
