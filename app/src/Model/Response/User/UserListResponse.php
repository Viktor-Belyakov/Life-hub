<?php

namespace App\Model\Response\User;

class UserListResponse
{
    /**
     * @var UserListItemsResponse[]|null
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
     * @return UserListResponse
     */
    public function setList(array $list): UserListResponse
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @param int $totalCount
     * @return UserListResponse
     */
    public function setTotalCount(int $totalCount): UserListResponse
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    /**
     * @param int $limit
     * @return UserListResponse
     */
    public function setLimit(int $limit): UserListResponse
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return UserListResponse
     */
    public function setOffset(int $offset): UserListResponse
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
