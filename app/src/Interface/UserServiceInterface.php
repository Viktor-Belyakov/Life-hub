<?php

namespace App\Interface;

use App\Model\Filter\User\TaskListFilter;
use App\Model\Filter\User\UserListFilter;
use App\Model\Request\User\TaskCreateRequest;
use App\Model\Request\User\TaskUpdateRequest;
use App\Model\Request\User\UserCreateRequest;
use App\Model\Request\User\UserUpdateRequest;
use App\Model\Response\User\UserItemResponse;
use App\Model\Response\User\UserListResponse;
use App\Model\Response\User\UserUpdateResponse;
use Symfony\Component\HttpFoundation\Response;

interface UserServiceInterface
{
    /**
     * @param UserCreateRequest $userCreateRequest
     * @return Response
     */
    public function create(UserCreateRequest $userCreateRequest): Response;

    /**
     * @param UserUpdateRequest $userUpdateRequest
     * @param int $id
     * @return UserUpdateResponse
     */
    public function update(UserUpdateRequest $userUpdateRequest, int $id): UserUpdateResponse;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param UserListFilter $filter
     * @return UserListResponse|null
     */
    public function getList(UserListFilter $filter): ?UserListResponse;

    /**
     * @param int $id
     * @return UserItemResponse|null
     */
    public function getById(int $id): ?UserItemResponse;
}
