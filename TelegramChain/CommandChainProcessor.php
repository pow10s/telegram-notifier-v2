<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:25
 */

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\Commands\Admin;
use TelegramNotifier\TelegramChain\Commands\Help;
use TelegramNotifier\TelegramChain\Commands\Search;
use TelegramNotifier\TelegramChain\Commands\Start;
use TelegramNotifier\TelegramChain\Commands\Stop;

class CommandChainProcessor
{
    public static function run($api, $closure)
    {
        $cc = new CommandChain($api);
        $cc->addCommands([
            new Start(),
/*            new Search(),
            new Help(),
            new Admin(),
            new Stop()*/
        ]);
        $cc->runCommand($closure);
    }
}