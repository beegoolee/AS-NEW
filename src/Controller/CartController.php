<?php

namespace App\Controller;

use App\Enums\OrderStatusEnum;
use App\Entity\ActualUserCart;
use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/api/order/make/', name: 'make_order', methods: ['POST'])]
    public function makeOrder(EntityManagerInterface $em, Request $request): JsonResponse
    {
        try {
            $user = $this->getUser();

            $actualCart = $user->getActualUserCart();

            $newOrder = new Order();
            $newOrder->setUser($user);

            $newOrder->setOrderProducts($actualCart->getCart());
            $newOrder->setCreateDate(new \DateTimeImmutable());
            $newOrder->setStatus(OrderStatusEnum::Pending->value);

            $em->persist($newOrder);

            $em->remove($actualCart);
            $em->flush();

            return $this->json(['success' => true, 'orderId' => $newOrder->getId()]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/user/get_order_history/', name: 'user_get_order_history', methods: ['GET'])]
    public function getUserOrderHistory(Request $request): JsonResponse
    {
        // получаем ВСЕ заказы юзера
        try {
            $user = $this->getUser();
            if(!$user){
                return $this->json([]);
            }

            $userOrdersCollection = $user->getOrders();

            $arOrderHistory = [];
            foreach ($userOrdersCollection as $order) {
                $arOrderHistoryItem = [];
                $arOrderProducts = $order->getOrderProducts()->getProducts();

                foreach ($arOrderProducts as $iProductId => $arProductData) {
                    $arOrderHistoryItem['products'][] = [
                        'productId' => $iProductId,
                        'quantity' => $arProductData['quantity'],
                        'total_price' => $arProductData['total_price'],
                        'base_price' => $arProductData['product_base_price'],
                    ];
                }

                $arOrderHistoryItem['id'] = $order->getId();
                $arOrderHistoryItem['date_create'] = $order->getCreateDate()->format('Y-m-d H:i:s');
                $arOrderHistoryItem['status'] = $order->getStatus();

                $arOrderHistory[] = $arOrderHistoryItem;
            }

            return $this->json($arOrderHistory);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    #[Route('/api/user/get_cart/', name: 'user_get_cart', methods: ['GET'])]
    public function getUserCart(EntityManagerInterface $em, Request $request): JsonResponse
    {
        try {
            $user = $this->getUser();

            if(!$user){
                return $this->json([]);
            }

            $actualCart = $user->getActualUserCart();

            $arCartProducts = [];
            if ($actualCart) {
                $arCartProducts = $actualCart->getCart()->getProducts();
            }

            // по id товаров получаем данные оных (названия, картинки и тд)
            $productsRepo = $em->getRepository(Product::class);
            $arCartProductsIDs = array_keys($arCartProducts);

            // TODO вместо findBy - прописать в репозитории кастомный метод для получения только урла, цены, картинки и названия на основе queryBuilder-a
            $arCartProductsData = $productsRepo->findBy(['id' => $arCartProductsIDs]);
            $arCartResult = [];

            foreach ($arCartProductsData as $oCartProductData) {
                $arCartResult[$oCartProductData->getId()] = [
                    'id' => $oCartProductData->getId(),
                    'quantity' => $arCartProducts[$oCartProductData->getId()]['quantity'],
                    'img' => $oCartProductData->getImage(),
                    'name' => $oCartProductData->getName(),
                    'price' => $arCartProducts[$oCartProductData->getId()]['total_price'],
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

            if(!$user){
                // need2auth
                return $this->json(['success' => false]);
            }

            $actualCart = $user->getActualUserCart();
            if (!$actualCart) {
                // нет корзины у человека, делаем
                $cart = new Cart();
                $cart->setOwner($user);


                $em->persist($cart);
                $em->flush();

                $actualCart = new ActualUserCart();
                $actualCart->setCart($cart);
                $actualCart->setUser($user);
            }

            $product = $em->getRepository(Product::class)->find($arRequest['product']);

            // Добавляем, изменяем количество, удаляем товар из актуальной корзины юзера
            $arCartProducts = $actualCart->getCart()->getProducts();
            if ($arCartProducts && array_key_exists($arRequest['product'], $arCartProducts)) {
                $arCartProducts[$arRequest['product']] = [
                    'quantity' => intval($arCartProducts[$arRequest['product']]['quantity']) + $arRequest['quantity'],
                    'product_base_price' => $product->getPrice(),
                    'total_price' => $product->getPrice() // TODO - сюда будем класть цену с учетом скидок. Можно добавить сравнение старой цены и новой - вдруг она изменилась пока мы корзину набирали
                ];

                if ($arCartProducts[$arRequest['product']]['quantity'] < 1) {
                    unset($arCartProducts[$arRequest['product']]);
                }
            } else {
                $arCartProducts[$arRequest['product']] = [
                    'quantity' => 1,
                    'product_base_price' => $product->getPrice(),
                    'total_price' => $product->getPrice() // TODO - сюда будем класть цену с учетом скидок
                ];
            }

            $actualCart->getCart()->setProducts($arCartProducts);
            $em->persist($actualCart);
            $em->flush();

            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }
}
