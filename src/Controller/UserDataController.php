<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserDataController extends AbstractController
{
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
