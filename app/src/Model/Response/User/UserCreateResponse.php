<?php

namespace App\Model\Response\User;

use DateTimeImmutable;

readonly class UserCreateResponse
{
    public function __construct(
        private string            $name,
        private string            $surname,
        private ?string           $middleName,
        private string            $email,
        private string            $phone,
        private array             $roles,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updateAt,
        private string            $token,
        private string $refreshToken,
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdateAt(): DateTimeImmutable
    {
        return $this->updateAt;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
