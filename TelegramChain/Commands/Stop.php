<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:20
 */

namespace TelegramNotifier\TelegramChain\Commands;


use TelegramNotifier\TelegramChain\TCommand;

class Stop implements TCommand
{
    public function onCommand($name)
    {
        if ($name != '/stop') return false;
        echo 'Stop command';
        return true;
    }
}