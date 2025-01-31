<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthRegController extends AbstractController
{
    #[Route('/api/auth_user/', name: 'app_auth', methods: ['POST'])]
    public function auth(): JsonResponse
    {
        // auth realized via lexik jwt bundle. This method needs for route only
    }

    #[Route('/api/register_user/', name: 'app_reg', methods: ['POST'])]
    public function register(UserPasswordHasherInterface $hasher, EntityManagerInterface $em, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();

        try {
            $obUser = new User();
            $userRepo = $em->getRepository(User::class);
            // Проверяем валидность логина, ставим его, если все ок и если он еще не зарегистрирован в базе
            $sLogin = trim($arRequest['username']);
            if (!filter_var($sLogin, FILTER_VALIDATE_EMAIL) && $userRepo->findOneByEmail($sLogin)) {
                throw new \Exception('Login already exists');
            } else {
                $obUser->setEmail($sLogin);
                $obUser->setPassword($hasher->hashPassword($obUser, $arRequest['password']));

                $em->persist($obUser);
                $em->flush();
            }
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return $this->json(['success' => true, 'message' => 'Регистрация успешна!']);
    }
}
