<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/api/user/get_order_history/', name: 'user_get_order_history', methods: ['GET'])]
    public function getUserOrderHistory(): JsonResponse
    {
        // получаем ВСЕ закрытые корзину (сиречь - заказы) юзера
        return $this->json([]);
    }

    #[Route('/api/user/get_cart/', name: 'user_get_cart', methods: ['GET'])]
    public function getUserCart(EntityManagerInterface $em): JsonResponse
    {
        try {
            $user = $this->getUser();

            // получаем товары из корзины (id и кол-во)
            $cartRepo = $em->getRepository(Cart::class);
            $actualCart = $cartRepo->getUserActualCart($user->getId());
            $arCartProducts = $actualCart->getProducts();

            // по id товаров получаем данные оных (названия, картинки и тд)
            $productsRepo = $em->getRepository(Product::class);
            $arCartProductsIDs = array_keys($arCartProducts);

            // TODO вместо findBy - прописать в репозитории кастомный метод для получения только урла, цены, картинки и названия на основе queryBuilder-a
            $arCartProductsData = $productsRepo->findBy(['id' => $arCartProductsIDs]);
            $arCartResult = [];

            foreach($arCartProductsData as $oCartProductData) {
                $arCartResult[$oCartProductData->getId()] = [
                    'id' => $oCartProductData->getId(),
                    'quantity' => $arCartProducts[$oCartProductData->getId()]['quantity'],
                    'img' => $oCartProductData->getImage(),
                    'name' => $oCartProductData->getName(),
                    'price' => $oCartProductData->getPrice(),
                    'url' => $oCartProductData->getUrl(),
                ];
            }

            // получаем корзину юзера (актуальную, тобишь, последнюю из БД)
            return $this->json($arCartResult);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/user/edit_cart/', name: 'user_edit_actual_cart', methods: ['POST'])]
    public function editUserCart(EntityManagerInterface $em, Request $request): JsonResponse
    {
        try {
            $user = $this->getUser();
            $arRequest = $request->toArray();

            $cartRepo = $em->getRepository(Cart::class);
            $actualCart = $cartRepo->findOneBy(['Owner' => $user->getId(), 'IsOrder' => false]);

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
                $cart->setOwner($user);
                $cart->setIsOrder(false);

                $cart->setProducts([
                    $arRequest['product'] => [
                        'quantity' => $arRequest['quantity'],
                    ]
                ]);
                $em->persist($cart);
                $em->flush();
            }

            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }
}
