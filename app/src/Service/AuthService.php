<?php

namespace App\Service;

use App\Repository\CustomRefreshTokenRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

readonly class AuthService
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private CustomRefreshTokenRepository $refreshTokenRepository
    ) {
    }

    public function updateTokens(string $refreshTokenValue): array
    {
        $refreshToken = $this->refreshTokenRepository->findByTokenValue($refreshTokenValue);

        if (!$refreshToken) {
            throw new BadCredentialsException('Invalid refresh token');
        }

        if ($refreshToken->getValid() < new \DateTime()) {
            throw new BadCredentialsException('Refresh token expired');
        }

        $user = $refreshToken->getUser();

        $newAccessToken = $this->jwtManager->create($user);


        $this->refreshTokenRepository->remove($refreshToken);
        $newRefreshToken = $this->refreshTokenRepository->createForUserWithTtl($user, 2592000); // TTL = 30 дней

        return [
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken->getRefreshToken()
        ];
    }
}