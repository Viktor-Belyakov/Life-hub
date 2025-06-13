<?php

namespace App\Model\Response\Task;

use App\Enum\TaskPriorityEnum;
use App\Enum\TaskStatusEnum;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

class TaskItemResponse
{
    /**
     * @var string
     */
    #[Assert\NotBlank]
    private string $title;

    /**
     * @var string
     */
    #[Assert\NotBlank]
    #[Assert\Choice(TaskPriorityEnum::PRIORITY_LIST)]
    private string $priority;

    /**
     * @var string
     */
    #[Assert\NotBlank]
    #[Assert\Choice(TaskStatusEnum::STATUS_LIST)]
    private string $status;

    /**
     * @var string
     */
    #[Assert\NotBlank]
    #[Assert\Length(min: 5)]
    private string $description;

    /**
     * @var DateTimeImmutable
     */
    #[Assert\NotBlank]
    private DateTimeImmutable $dueDate;

    /**
     * @var string|null
     */
    private ?string $comment;

    /**
     * @var int
     */
    #[Assert\NotBlank]
    private int $assignedTo;

    /**
     * @var DateTimeImmutable
     */
    #[Assert\NotBlank]
    private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     */
    #[Assert\NotBlank]
    private DateTimeImmutable $updatedAt;

    /**
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $completedAt;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return TaskItemResponse
     */
    public function setTitle(string $title): TaskItemResponse
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return TaskItemResponse
     */
    public function setPriority(string $priority): TaskItemResponse
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return TaskItemResponse
     */
    public function setStatus(string $status): TaskItemResponse
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return TaskItemResponse
     */
    public function setDescription(string $description): TaskItemResponse
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }

    /**
     * @param DateTimeImmutable $dueDate
     * @return TaskItemResponse
     */
    public function setDueDate(DateTimeImmutable $dueDate): TaskItemResponse
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return TaskItemResponse
     */
    public function setComment(?string $comment): TaskItemResponse
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getAssignedTo(): int
    {
        return $this->assignedTo;
    }

    /**
     * @param int $assignedTo
     * @return TaskItemResponse
     */
    public function setAssignedTo(int $assignedTo): TaskItemResponse
    {
        $this->assignedTo = $assignedTo;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     * @return TaskItemResponse
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): TaskItemResponse
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeImmutable $updatedAt
     * @return TaskItemResponse
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): TaskItemResponse
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * @param DateTimeImmutable|null $completedAt
     * @return TaskItemResponse
     */
    public function setCompletedAt(?DateTimeImmutable $completedAt): TaskItemResponse
    {
        $this->completedAt = $completedAt;
        return $this;
    }
}
