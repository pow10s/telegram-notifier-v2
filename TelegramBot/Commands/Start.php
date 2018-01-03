<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 1:14
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\Commands\CommandInterface;

class Start extends Command implements CommandInterface
{
    public function onCommand($command)
    {
        $this->start();
    }
}