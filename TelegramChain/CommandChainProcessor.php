<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:25
 */

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\Commands\Search;
use TelegramNotifier\TelegramChain\Commands\Start;
use TelegramNotifier\TelegramChain\Commands\Stop;

class CommandChainProcessor
{
    public static function run($command)
    {
        $cc = new CommandChain();
        $cc->addCommand(new Start());
        $cc->addCommand(new Stop());
        $cc->addCommand(new Search());
        $cc->runCommand($command);
    }
}