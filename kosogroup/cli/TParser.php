<?php

namespace kosogroup\cli;

use kosogroup\cli\dto\TCommand;
use kosogroup\cli\exceptions\TCommandException;
use kosogroup\cli\exceptions\TCommandOptionException;

class TParser
{

    public static function walk(TCommandLineInterface $cli, array $arguments): TCommand
    {
        return static::walkToCommand($cli, $arguments);
    }


    protected static function walkToCommand(TCommandLineInterface $cli, array $arguments): TCommand
    {
        if (empty($arguments))
            throw new TCommandException('command: wa');

        $lexeme = array_shift($arguments);

        if (!$cli->hasCommand($lexeme))
            return static::walkToCommand($cli, $arguments);

        $command = $cli->getCommand($lexeme);

        if ($command->needValue()) {
            if (empty($arguments))
                throw new TCommandException("command [{$command->name}]: Value required - is empty!");

            $lexeme = array_shift($arguments);
            if (static::isOption($lexeme))
                throw new TCommandException("command [{$command->name}]: Value required - is option accepted!");

            $command->setValue($lexeme);
        }

        if (empty($arguments)) return $command;

        //ref: add if required attr
        //if(empty($arguments)) throw new TCommandException('invalid required attribute');
        //if (empty($arguments)) return $command;

        $command = static::walkOnOptions($command, $arguments);

        return $command;
    }

    protected static function walkOnOptions(TCommand $command, array $arguments): TCommand
    {
        if (empty($arguments)) return $command;
        $lexeme = array_shift($arguments);

        if (static::isOption($lexeme)) {
            if ($command->hasOption($lexeme)) {
                $option = $command->getOption($lexeme);
                $option->setUsed();

                if ($option->needValue()) {
                    if (empty($arguments))
                        throw new TCommandOptionException("command [{$command->name}] option [{$option->name}]: Value required - is empty!");

                    $lexeme = array_shift($arguments);
                    if (static::isOption($lexeme))
                        throw new TCommandOptionException("command [{$command->name}] option [{$option->name}]: Value required - is option accepted!");

                    $option->setValue($lexeme);
                }

                static::walkOnOptions($command, $arguments);
            } else throw new TCommandOptionException("command [{$command->name}]: Undefined option!");
        } else static::walkOnOptions($command, $arguments);

        return $command;
    }

    public static function isOption(string $lexeme)
    {
        return count(explode('--', $lexeme)) == 2 ||  count(explode('-', $lexeme)) == 2;
    }
}
