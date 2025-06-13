<?php

namespace App\Model\Response\Task;

class TaskListResponse
{
    /**
     * @var TaskItemResponse[]|null
     */
    private array $list;

    /**
     * @var int
     */
    private int $totalCount;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var int
     */
    private int $offset;

    /**
     * @param array $list
     * @return TaskListResponse
     */
    public function setList(array $list): TaskListResponse
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @param int $totalCount
     * @return TaskListResponse
     */
    public function setTotalCount(int $totalCount): TaskListResponse
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    /**
     * @param int $limit
     * @return TaskListResponse
     */
    public function setLimit(int $limit): TaskListResponse
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return TaskListResponse
     */
    public function setOffset(int $offset): TaskListResponse
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
