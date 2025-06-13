<?php

namespace App\Model\Filter\Task;

use App\Model\Filter\Task\TaskCriteria;
use App\Model\Filter\Task\TaskSort;

class TaskListFilter
{
    /**
     * @var TaskCriteria[]
     */
    private array $criteria = [];

    /**
     * @var int
     */
    private int $limit = 20;

    /**
     * @var int
     */
    private int $offset = 0;

    /**
     * @var TaskSort[]
     */
    private array $sort = [];

    /**
     * @param TaskCriteria[] $criteria
     * @return $this
     */
    public function setCriteria(array $criteria): self
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return TaskCriteria[]
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param TaskSort[] $sort
     * @return $this
     */
    public function setSort(array $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return TaskSort[]
     */
    public function getSort(): array
    {
        return $this->sort;
    }
}
