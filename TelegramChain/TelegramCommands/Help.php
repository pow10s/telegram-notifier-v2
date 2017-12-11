<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 11.12.17
 * Time: 18:58
 */

namespace TelegramNotifier\TelegramChain\TelegramCommands;


use TelegramNotifier\TelegramChain\TelegramCommandsParser;

class Help extends TelegramCommandsParser
{
    public function parse(string $command)
    {
        if ($this->canHandleCommand($command)) {
            print ('Help' .$command);
        } else {
            parent::parse($command);
        }

    }
}