<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:25
 */

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\Commands\Help;
use TelegramNotifier\TelegramChain\Commands\Search;
use TelegramNotifier\TelegramChain\Commands\Start;

class CommandChainProcessor
{
    public static function run($api, $closure)
    {
        $cc = new CommandChain($api);
        $cc->addCommands([
            new Search(),
            new Start(),
            new Help()
        ]);
        print_r($cc->getCommands());
        $cc->runCommand($closure);
    }
}