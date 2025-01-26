<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/app_get_user_cart/', name: 'app_get_user_actual_cart', methods: ['GET'])]
    public function getUserCart(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();
        try {
            $cartOwner = $em->getRepository(User::class)->findOneBy(['id' => $arRequest['userId']]);

            $cartRepo = $em->getRepository(Cart::class);
            $actualCart = $cartRepo->findOneBy(['Owner' => $cartOwner->getId(), 'IsOrder' => false]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
        // получаем корзину юзера (актуальную, тобишь, последнюю из БД)
        return $this->json($actualCart);
    }

    #[Route('/api/app_edit_user_cart/', name: 'app_get_user_actual_cart', methods: ['POST'])]
    public function editUserCart(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();
        try {
            $cartOwner = $em->getRepository(User::class)->findOneBy(['id' => $arRequest['userId']]);

            $cartRepo = $em->getRepository(Cart::class);
            $actualCart = $cartRepo->findOneBy(['Owner' => $cartOwner->getId(), 'IsOrder' => false]);

            if ($actualCart) {
                // Добавляем, изменяем количество, удаляем товар из актуальной корзины юзера
                $arCartProducts = $actualCart->getProducts();

                if (array_key_exists($arRequest['product'], $arCartProducts)) {
                    $arCartProducts[$arRequest['product']]['quantity'] = intval($arCartProducts[$arRequest['product']]['quantity']) + $arRequest['quantity'];
                    if ($arCartProducts[$arRequest['product']]['quantity'] < 1) {
                        unset($arCartProducts[$arRequest['product']]);
                    }
                } else {
                    $arCartProducts[$arRequest['product']] = [
                        'quantity' => 1,
                    ];
                }

                $actualCart->setProducts($arCartProducts);
                $em->persist($actualCart);
                $em->flush();
            } else {
                // нет корзины у человека, делаем
                $cart = new Cart();
                $cart->setOwner($cartOwner);
                $cart->setIsOrder(false);

                $cart->setProducts([
                    $arRequest['product'] => [
                        'quantity' => $arRequest['quantity'],
                    ]
                ]);
                $em->persist($cart);
                $em->flush();
            }
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }

        return $this->json(['success' => true]);
    }
}
