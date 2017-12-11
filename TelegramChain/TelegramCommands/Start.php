<?php

namespace TelegramNotifier\TelegramChain\TelegramCommands;


use TelegramNotifier\TelegramChain\TelegramCommandsParser;

class Start extends TelegramCommandsParser
{
    public function parse(string $command)
    {
        if ($this->canHandleCommand($command)) {
            print('Command: start');
        } else {
            parent::parse($command);
        }
    }
}