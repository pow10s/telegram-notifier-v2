<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:29
 */

namespace TelegramNotifier\TelegramChain\Commands;


use TelegramNotifier\TelegramChain\TCommand;

class Search implements TCommand
{
    public function onCommand($name)
    {
        if ($name != '/search') return false;
        echo 'Search command';
        return true;
    }
}