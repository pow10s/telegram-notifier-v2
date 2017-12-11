<?php

namespace TelegramNotifier\TelegramChain\TelegramCommands;


use TelegramNotifier\TelegramChain\TelegramCommandsParser;

class Help extends TelegramCommandsParser
{
    public function parse(string $command)
    {
        if ($this->canHandleCommand($command)) {
            print ('Command: '. $command);
        } else {
            parent::parse($command);
        }
    }
}