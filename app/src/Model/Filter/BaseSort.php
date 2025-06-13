<?php

namespace App\Model\Filter;

class BaseSort
{
    /**
     * @var string
     */
    private string $field = 'id';

    /**
     * @var string
     */
    private string $direction = 'desc';

    /**
     * @param string $field
     * @return $this
     */
    public function setField(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function setDirection(string $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
