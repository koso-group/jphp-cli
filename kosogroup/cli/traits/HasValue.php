<?php

namespace kosogroup\cli\traits;

trait HasValue
{
    protected bool $needValue = false;
    protected string $value = '';

    public function needValue(): bool
    {
        return $this->needValue;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
