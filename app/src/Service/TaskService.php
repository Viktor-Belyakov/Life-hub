<?php

namespace App\Service;

use App\Entity\Task;
use App\Helper\ValidatorHelper;
use App\Interface\TaskServiceInterface;
use App\Model\Filter\Task\TaskListFilter;
use App\Model\Request\Task\TaskCreateRequest;
use App\Model\Request\Task\TaskUpdateRequest;
use App\Model\Response\Task\TaskCreateResponse;
use App\Model\Response\Task\TaskItemResponse;
use App\Model\Response\Task\TaskListResponse;
use App\Model\Response\Task\TaskUpdateResponse;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

readonly class TaskService implements TaskServiceInterface
{
    public function __construct(
        private ValidatorHelper $validatorHelper,
        private SerializerInterface $serializer,
        private UserRepository $userRepository,
        private TaskRepository $taskRepository,
    ) {
    }

    /**
     * @param TaskCreateRequest $taskCreateRequest
     * @return TaskCreateResponse
     */
    public function create(TaskCreateRequest $taskCreateRequest): TaskCreateResponse
    {
        $user = $this->userRepository->find($taskCreateRequest->getAssignedTo());
        Assert::notNull($user, sprintf('User %s not found', $taskCreateRequest->getAssignedTo()));
        $task = new Task();
        $task
            ->setTitle($taskCreateRequest->getTitle())
            ->setDescription($taskCreateRequest->getDescription())
            ->setComment($taskCreateRequest->getComment())
            ->setPriority($taskCreateRequest->getPriority())
            ->setDueDate($taskCreateRequest->getDueDate())
            ->setAssignedTo($user);

        $this->validatorHelper->validate($task);
        $this->taskRepository->save($task, true);

        return (new TaskCreateResponse(
            $task->getTitle(),
            $task->getDescription(),
            $task->getPriority(),
            $task->getDueDate(),
            $task->getComment(),
            $task->getCreatedAt(),
            $task->getAssignedTo()->getId()
        ));
    }

    /**
     * @param TaskUpdateRequest $taskUpdateRequest
     * @param int $id
     * @return TaskUpdateResponse
     */
    public function update(TaskUpdateRequest $taskUpdateRequest, int $id): TaskUpdateResponse
    {
        $user = $this->userRepository->find($taskUpdateRequest->getAssignedTo());
        Assert::notNull($user, sprintf('User %s not found', $taskUpdateRequest->getAssignedTo()));
        $task = $this->taskRepository->find($id);
        Assert::notNull($user, sprintf('Task %s not found', $id));
        $task
            ->setTitle($taskUpdateRequest->getTitle())
            ->setDescription($taskUpdateRequest->getDescription())
            ->setComment($taskUpdateRequest->getComment())
            ->setPriority($taskUpdateRequest->getPriority())
            ->setDueDate($taskUpdateRequest->getDueDate())
            ->setStatus($taskUpdateRequest->getStatus())
            ->setCompletedAt($taskUpdateRequest->getCompletedAt())
            ->setAssignedTo($user);

        $this->validatorHelper->validate($task);
        $this->taskRepository->save($task, true);

        return (new TaskUpdateResponse(
            $task->getTitle(),
            $task->getDescription(),
            $task->getPriority(),
            $task->getDueDate(),
            $task->getComment(),
            $task->getCreatedAt(),
            $task->getAssignedTo()->getId()
        ));
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->taskRepository->delete($id);
    }

    /**
     * @param TaskListFilter $filter
     * @return TaskListResponse|null
     */
    public function getList(TaskListFilter $filter): ?TaskListResponse
    {
        $result = $this
            ->taskRepository
            ->findByCriteria(
                $filter->getCriteria(),
                $filter->getSort(),
                $filter->getLimit(),
                $filter->getOffset()
            );

        $response = new TaskListResponse();
        $list = [];
        foreach ($result['list'] as $task) {
            $list[] = $this->serializer->deserialize($task, TaskItemResponse::class, 'json');
        }
        $response
            ->setList($list)
            ->setTotalCount($result['totalCount'] ?? 0)
            ->setLimit($filter->getLimit())
            ->setOffset($filter->getOffset());
        return $response;
    }

    public function getById(int $id): ?TaskItemResponse
    {
        // TODO: Implement getById() method.
    }
}
