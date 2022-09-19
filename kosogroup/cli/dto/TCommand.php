<?php

namespace kosogroup\cli\dto;

use kosogroup\cli\traits\HasValue;

class TCommand
{
    use HasValue;


    public string $name;
    public \Closure $closure;
    public string $description = '';

    function __construct(string $name, \Closure $closure = null, bool $needValue = false, $description = null)
    {
        $this->name = $name;
        $this->closure = $closure;

        $this->needValue = $needValue;
        $this->description = $description;
    }

    
    protected array $_options = [];
    public function addOption(string $name, bool $needValue = false, string $description = null, string $alias = null)
    {
        $option = new TCommandOption($name, $needValue, $description, $alias);
        $this->_options[$option->name] = $option;
        $this->_options[$option->alias] = $option;

        return $this;
    }
    public function hasOption($name) : bool { return isset($this->_options[$name]); }
    public function getOption($name) : TCommandOption { return $this->_options[$name]; }

    public function execute()
    {
        if($this->closure)
            $this->closure->call($this, $this);
    }    
}