<?php

namespace App\Interface;

use App\Model\Filter\Task\TaskListFilter;
use App\Model\Request\Task\TaskCreateRequest;
use App\Model\Request\Task\TaskUpdateRequest;
use App\Model\Response\Task\TaskCreateResponse;
use App\Model\Response\Task\TaskItemResponse;
use App\Model\Response\Task\TaskListResponse;
use App\Model\Response\Task\TaskUpdateResponse;
use Symfony\Component\HttpFoundation\Response;

interface TaskServiceInterface
{
    /**
     * @param TaskCreateRequest $taskCreateRequest
     * @return TaskCreateResponse
     */
    public function create(TaskCreateRequest $taskCreateRequest): TaskCreateResponse;

    /**
     * @param TaskUpdateRequest $taskUpdateRequest
     * @param int $id
     * @return TaskUpdateResponse
     */
    public function update(TaskUpdateRequest $taskUpdateRequest, int $id): TaskUpdateResponse;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param TaskListFilter $filter
     * @return TaskListResponse|null
     */
    public function getList(TaskListFilter $filter): ?TaskListResponse;

    /**
     * @param int $id
     * @return TaskItemResponse|null
     */
    public function getById(int $id): ?TaskItemResponse;
}
