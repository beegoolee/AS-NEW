<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserDataController extends AbstractController
{
    #[Route('/api/get_user_recent_products/', name: 'get_user_recent_products', methods: ['GET'])]
    public function getUserRecentlyViewed()
    {
        $arReturn = [];
        $user = $this->getUser();
        if($user){
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
