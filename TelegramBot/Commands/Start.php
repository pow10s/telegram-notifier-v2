<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 1:14
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\TelegramBot\Agregator;

class Start implements CommandInterface
{
    public function runCommand($message)
    {
        $chatId = $message->getChat()->getId();
        TelegramDb::addContact($chatId);
        $bot->sendMessage($chatId, $this->getDecription());
    }
}