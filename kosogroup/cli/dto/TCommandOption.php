<?php

namespace kosogroup\cli\dto;

use kosogroup\cli\traits\HasValue;

class TCommandOption
{
    use HasValue;


    public string $name;
    public string $alias;
    public string $description = '';

    protected bool $_isUsed = false;

    function __construct(string $name, bool $needValue = false, string $description = null, string $alias = null)
    {
        $this->name = "--{$name}";
        $this->alias = "-{$alias}";

        $this->needValue = $needValue;
        $this->description = $description;
    }

    public function setUsed(bool $isUsed = true) { $this->_isUsed = $isUsed; return $this; }
    public function isUsed() { return $this->_isUsed; }
}