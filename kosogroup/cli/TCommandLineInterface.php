<?php

namespace kosogroup\cli;

use kosogroup\cli\dto\TCommand;

class TCommandLineInterface
{
    protected array $_commands = [];
    
    public function addCommandWO(string $name, \Closure $closure = null, bool $needValue = false, string $description = null) : TCommand
    {
        $command = new TCommand($name, $closure, $needValue, $description);
        $this->_commands[$name] = $command;
        return $command;
    }
    public function addCommand(string $name, \Closure $closure = null, bool $needValue = false, string $description = null)
    {
       $this->addCommandWO($name, $closure, $needValue, $description);
       return $this;
    }
    public function hasCommand($name) : bool { return isset($this->_commands[$name]); }
    public function getCommand($name) : TCommand { return $this->_commands[$name]; }


    public function handle(array $arguments = null)
    {
        if ($arguments === null) {

            $arguments = $GLOBALS['argv'];
            $appPath = array_shift($arguments);
        }

        if(empty($arguments)) return;

        $command = TParser::walk($this, $arguments);
        if($command) $command->execute();
    }
    
}