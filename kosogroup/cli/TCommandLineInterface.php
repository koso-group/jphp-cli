<?php

namespace kosogroup\cli;

use kosogroup\cli\dto\TCommand;

class TCommandLineInterface
{
    protected array $_commands = [];
    public function getCommands()
    {
        return $this->_commands;
    }

    public function addCommandWO(string $name, \Closure $closure = null, bool $needValue = false, string $description = null): TCommand
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
    public function hasCommand($name): bool
    {
        return isset($this->_commands[$name]);
    }
    public function getCommand($name): TCommand
    {
        return $this->_commands[$name];
    }


    public function handle(array $arguments = null)
    {
        if ($arguments === null) {

            $arguments = $GLOBALS['argv'];
            $appPath = array_shift($arguments);
        }

        if (empty($arguments)) return;

        $command = TParser::walk($this, $arguments);
        if ($command) $command->execute();
    }



    function __construct()
    {
        $cli = $this;
        $helperCommandClosure = function () use ($cli) {
            $printer = TPrinter::startWith(TFormatting::create('_reset'))
                ->concatWith("Helper commands: \n\r", TFormatting::create('bold'));

            foreach ($cli->getCommands() as $commandName => $command) {
                if (($commandName == "help") || ($commandName == "?")) continue;

                $printer->concatWith("{$command->name} ", TFormatting::create('underline'));
                if ($command->description)
                    $printer->concatWith("\r\t\t\t\t{$command->description}", TFormatting::create('italic'));

                $printer->concat("\n\r");
                if (!empty($command->getOprions()))
                    foreach ($command->getOprions() as $optionName => $option) {
                        if ($optionName != $option->name) continue;

                        $printer->concatWith("\r\t{$option->name}", TFormatting::create('blink'));

                        if ($option->alias)
                            $printer->concatWith(" {$option->alias}", TFormatting::create('blink'));

                        if ($option->description)
                            $printer->concatWith("\r\t\t\t\t{$option->description}", TFormatting::create('italic'));

                        $printer->concat("\n\r");
                    }

                $printer->concat("\n\r");
            }

            echo ($printer->print());
        };

        $this->addCommand('help', $helperCommandClosure, false);
        $this->addCommand('?', $helperCommandClosure, false);
    }
}
