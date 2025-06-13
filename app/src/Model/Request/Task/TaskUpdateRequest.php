<?php

namespace App\Model\Request\Task;

class TaskUpdateRequest
{
    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var string|null
     */
    private ?string $status;

    /**
     * @var string|null
     */
    private ?string $priority;

    /**
     * @var string|null
     */
    private ?string $dueDate;

    /**
     * @var string|null
     */
    private ?string $completedAt;

    /**
     * @var string|null
     */
    private ?string $comment;

    /**
     * @var int|null
     */
    private ?int $assignedTo;

    /**
     * @param string|null $title
     * @return TaskUpdateRequest
     */
    public function setTitle(?string $title): TaskUpdateRequest
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string|null $description
     * @return TaskUpdateRequest
     */
    public function setDescription(?string $description): TaskUpdateRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string|null $status
     * @return TaskUpdateRequest
     */
    public function setStatus(?string $status): TaskUpdateRequest
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string|null $priority
     * @return TaskUpdateRequest
     */
    public function setPriority(?string $priority): TaskUpdateRequest
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string|null $dueDate
     * @return TaskUpdateRequest
     */
    public function setDueDate(?string $dueDate): TaskUpdateRequest
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param string|null $completedAt
     * @return TaskUpdateRequest
     */
    public function setCompletedAt(?string $completedAt): TaskUpdateRequest
    {
        $this->completedAt = $completedAt;
        return $this;
    }

    /**
     * @param string|null $comment
     * @return TaskUpdateRequest
     */
    public function setComment(?string $comment): TaskUpdateRequest
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param int|null $assignedTo
     * @return TaskUpdateRequest
     */
    public function setAssignedTo(?int $assignedTo): TaskUpdateRequest
    {
        $this->assignedTo = $assignedTo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * @return string|null
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * @return string|null
     */
    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return int|null
     */
    public function getAssignedTo(): ?int
    {
        return $this->assignedTo;
    }
}
