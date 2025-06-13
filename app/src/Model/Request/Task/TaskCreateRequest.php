<?php

namespace App\Model\Request\Task;

use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\TaskPriorityEnum;
use DateTimeImmutable;

class TaskCreateRequest
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
    #[Assert\Length(min: 5)]
    private string $description;

    /**
     * @var DateTimeImmutable
     */
    #[Assert\NotBlank]
    private DateTimeImmutable $dueDate;

    /**
     * @var string
     */
    #[Assert\NotBlank]
    private string $comment;

    /**
     * @var int
     */
    #[Assert\NotBlank]
    private int $assignedTo;

    /**
     * @param string $title
     * @return TaskCreateRequest
     */
    public function setTitle(string $title): TaskCreateRequest
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return TaskCreateRequest
     */
    public function setDescription(string $description): TaskCreateRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $priority
     * @return TaskCreateRequest
     */
    public function setPriority(string $priority): TaskCreateRequest
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param DateTimeImmutable $dueDate
     * @return TaskCreateRequest
     */
    public function setDueDate(DateTimeImmutable $dueDate): TaskCreateRequest
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param string $comment
     * @return TaskCreateRequest
     */
    public function setComment(string $comment): TaskCreateRequest
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param int $assignedTo
     * @return TaskCreateRequest
     */
    public function setAssignedTo(int $assignedTo): TaskCreateRequest
    {
        $this->assignedTo = $assignedTo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getAssignedTo(): int
    {
        return $this->assignedTo;
    }
}
