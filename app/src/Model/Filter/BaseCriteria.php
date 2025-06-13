<?php

namespace App\Model\Filter;

class BaseCriteria
{
    /**
     * @var string
     */
    private string $field;

    /**
     * @var string
     */
    private string $value;

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
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
