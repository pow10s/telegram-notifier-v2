<?php

namespace TelegramNotifier\TelegramChain;


abstract class CommandParser
{
    private $successor;

    private $commands = [
        '/start',
        '/help',
        '/search',
        '/admin',
        '/stop'
    ];

    public function __construct(CommandParser $successor = null)
    {
        $this->successor = $successor;
    }

    public function parse(string $commandName)
    {
        $successor = $this->successor;
        if ($successor) {
            $successor->parse($commandName);
        } else {
            print('I cant get command:' . $commandName);
        }
    }

    public function getSuccessor()
    {
        return $this->successor;
    }

    public function canHandleCommand(string $commandName): bool
    {
        if ($commandName) {
            if (in_array($commandName, $this->commands)) {
                return true;
            }
        }
        return false;
    }
}