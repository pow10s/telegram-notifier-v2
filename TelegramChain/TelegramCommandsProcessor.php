<?php

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\TelegramCommands\Help;
use TelegramNotifier\TelegramChain\TelegramCommands\Search;
use TelegramNotifier\TelegramChain\TelegramCommands\Start;

class TelegramCommandsProcessor
{
    public static function run($commands)
    {
        $start = new Start();
        $search = new Search($start);
        $help = new Help($search);
        if (is_array($commands)) {
            foreach ($commands as $command) {
                $help->parse($command);
            }
        } else {
            $help->parse($commands);
        }
    }
}