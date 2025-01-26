<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthRegController extends AbstractController
{
    #[Route('/api/auth_user/', name: 'app_auth', methods: ['POST'])]
    public function auth(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();
        try {
            $userRepo = $em->getRepository(User::class);

            $sLogin = trim($arRequest['login']);
            $actualUser = $userRepo->findByLogin($sLogin);

            if ($actualUser) {
                $sPassword = trim($arRequest['password']);
                if ($actualUser->getPasswordHash() === md5($sPassword)) {
                    return $this->json(['success' => true, 'message' => 'Авторизация успешна!']);
                }
            } else {
                throw new \Exception('Пользователь с таким логином не существует');
            }
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return $this->json(['success' => false, 'message' => 'Неизвестная ошибка']);
    }


    #[Route('/api/register_user/', name: 'app_reg', methods: ['POST'])]
    public function register(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $arRequest = $request->toArray();

        try {
            $obUser = new User();
            $userRepo = $em->getRepository(User::class);
            // Проверяем валидность логина, ставим его, если все ок и если он еще не зарегистрирован в базе
            $sLogin = trim($arRequest['login']);
            if (!filter_var($sLogin, FILTER_VALIDATE_EMAIL) && $userRepo->findByLogin($sLogin)) {
                throw new \Exception('Login already exists');
            } else {
                $obUser->setLogin($sLogin);
            }

            // Проверяем валидность пароля, ставим его, если все ок
            $sPassword = trim($arRequest['password']);
            if ((strlen($sPassword) < 8)) {
                throw new \Exception('Пароль должен быть не короче 8 символов');
            } else {
                $obUser->setPasswordHash($arRequest['password']);
            }

            $em->persist($obUser);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return $this->json(['success' => true, 'message' => 'Регистрация успешна!']);
    }
}
