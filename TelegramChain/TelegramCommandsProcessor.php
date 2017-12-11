<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 11.12.17
 * Time: 18:57
 */

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\TelegramCommands\Help;
use TelegramNotifier\TelegramChain\TelegramCommands\Start;

class TelegramCommandsProcessor
{
    public static function run($commands)
    {
        $start = new Start();
        $help = new Help($start);
        if (is_array($commands)) {
            foreach ($commands as $command) {
                $help->parse($command);
            }
        } else {
            $help->parse($commands);
        }
    }
}