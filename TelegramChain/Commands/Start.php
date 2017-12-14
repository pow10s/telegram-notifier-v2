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
        if ($name != '/start') return false;
        $bot = new \TelegramBot\Api\BotApi('438332110:AAFCgeVIz_vq6HJznmLqbvTcxbZ0v4lCEzY');
        $bot->sendMessage('75586930','Hello world');
        return true;
    }
}