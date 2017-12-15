<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:19
 */

namespace TelegramNotifier\TelegramChain\Commands;


use TelegramNotifier\TelegramChain\TCommand;

class Start implements TCommand
{
    public function onCommand($name)
    {
        if ($name != '/start') {
            return false;
        }
        
        $text = 'Hello, thank`s for subscribing. Commands list: /help';
        return true;
    }
}