<?php

namespace App\Service;

use App\Entity\User;
use App\Helper\ValidatorHelper;
use App\Interface\UserServiceInterface;
use App\Model\Filter\User\UserListFilter;
use App\Model\Request\User\UserCreateRequest;
use App\Model\Request\User\UserUpdateRequest;
use App\Model\Response\User\UserItemResponse;
use App\Model\Response\User\UserListResponse;
use App\Model\Response\User\UserUpdateResponse;
use App\Repository\UserRepository;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorHelper $validator,
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $userPasswordHasher,
        private AuthenticationSuccessHandler $successHandler,
    ) {
    }

    /**
     * @param UserCreateRequest $userCreateRequest
     * @return Response
     */
    public function create(UserCreateRequest $userCreateRequest): Response
    {
        $user = (new User())
            ->setName($userCreateRequest->getName())
            ->setSurname($userCreateRequest->getSurname())
            ->setMiddleName($userCreateRequest->getMiddleName())
            ->setPhone($userCreateRequest->getPhone())
            ->setEmail($userCreateRequest->getEmail())
            ->setRoles($userCreateRequest->getRoles());

        $password = $this->userPasswordHasher->hashPassword($user, $userCreateRequest->getPassword());
        $user->setPassword($password);

        $this->validator->validate($user);
        $this->userRepository->save($user, true);

        return $this->successHandler->handleAuthenticationSuccess($user);
    }

    /**
     * @param UserUpdateRequest $userUpdateRequest
     * @param int $id
     * @return UserUpdateResponse
     * @throws Exception
     */
    public function update(UserUpdateRequest $userUpdateRequest, int $id): UserUpdateResponse
    {
        $user = $this->userRepository->find($id);
        $user
            ->setName($userUpdateRequest->getName())
            ->setSurname($userUpdateRequest->getSurname())
            ->setMiddleName($userUpdateRequest->getMiddleName())
            ->setPhone($userUpdateRequest->getPhone())
            ->setRoles($userUpdateRequest->getRoles())
            ->setEmail($userUpdateRequest->getEmail());

        $password = $this->userPasswordHasher->hashPassword($user, $userUpdateRequest->getPassword());
        $user->setPassword($password);

        $this->validator->validate($user);
        $this->userRepository->save($user);

        return (new UserUpdateResponse(
            $user->getName(),
            $user->getSurname(),
            $user->getMiddleName(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getRoles(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        ));
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->userRepository->delete($id);
    }

    /**
     * @param UserListFilter $filter
     * @return UserListResponse|null
     */
    public function getList(UserListFilter $filter): ?UserListResponse
    {
        $result = $this
            ->userRepository
            ->findByCriteria(
                $filter->getCriteria(),
                $filter->getSort(),
                $filter->getLimit(),
                $filter->getOffset()
            );

        return $this->serializer->denormalize($result, UserListResponse::class);
    }

    /**
     * @param int $id
     * @return UserItemResponse|null
     */
    public function getById(int $id): ?UserItemResponse
    {
        $user = $this->userRepository->find($id);
        return (new UserItemResponse(
            $user->getId(),
            $user->getName(),
            $user->getSurname(),
            $user->getMiddleName(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getRoles(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        ));
    }
}
