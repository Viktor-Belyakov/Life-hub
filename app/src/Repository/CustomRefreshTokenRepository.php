<?php

namespace App\Repository;

use App\Entity\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomRefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    /**
     * Метод для поиска refresh токена по значению
     */
    public function findByTokenValue(string $tokenValue): ?RefreshToken
    {
        return $this->findOneBy(['refreshToken' => $tokenValue]);
    }

    public function createForUserWithTtl(UserInterface $user, int $ttl): RefreshTokenInterface
    {
        $refreshToken = new RefreshToken();
        $refreshToken->setUsername($user->getUserIdentifier());
        $refreshToken->setUser($user);
        $refreshToken->setRefreshToken(bin2hex(random_bytes(64)));
        $refreshToken->setValid((new \DateTime())->modify("+$ttl seconds"));

        $this->getEntityManager()->persist($refreshToken);
        $this->getEntityManager()->flush();

        return $refreshToken;
    }

    public function remove(RefreshToken $token): void
    {
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
    }
}
