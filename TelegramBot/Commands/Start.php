<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 1:14
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\ServiceContainer\Loader;

class Start implements CommandInterface
{
    public function runCommand($message)
    {
        $db = Loader::resolve('db');
        $chatId = $message->getChat()->getId();
        $db->addContact($chatId);
        $bot->sendMessage($chatId, $this->getDecription());
    }
}