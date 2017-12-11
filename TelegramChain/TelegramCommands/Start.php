<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 11.12.17
 * Time: 19:04
 */

namespace TelegramNotifier\TelegramChain\TelegramCommands;


use TelegramNotifier\TelegramChain\TelegramCommandsParser;

class Start extends TelegramCommandsParser
{
    public function parse(string $command)
    {
        if ($this->canHandleCommand($command)) {
            print('Started');
        } else {
            parent::parse($command);
        }

    }
}