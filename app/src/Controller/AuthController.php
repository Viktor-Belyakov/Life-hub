<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use OpenApi\Attributes as OA;

#[OA\Response(
    response: 500,
    description: 'Внутренняя ошибка сервера'
)]
#[Route("/auth", name: "auth")]
class AuthController extends AbstractController
{
    public function __construct(
        readonly private AuthService $authService,
    ) {
    }

    #[Route("/refresh", name: "refresh", methods: ["POST"])]
    public function refresh(Request $request): JsonResponse
    {
        $refreshTokenValue = $request->toArray()['refresh_token'] ?? null;

        if (!$refreshTokenValue) {
            throw new BadCredentialsException('No refresh token provided');
        }

        try {
            $data = $this->authService->updateTokens($refreshTokenValue);
        } catch (\Exception $e) {
            throw new BadCredentialsException($e->getMessage());
        }

        return $this->json($data, Response::HTTP_OK);
    }
}
