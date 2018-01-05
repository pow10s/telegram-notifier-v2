<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 1:59
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\ServiceContainer\Loader;

class Stop extends Command
{
    protected $name = 'stop';

    public function handle($arguments)
    {
        $client = $this->client;
        $db = Loader::resolve('db');
        $client->command('stop', function ($message) use ($client, $db) {
            $db->deleteContact($message->getChat()->getId());
            $text = 'You have been deleted from bot database. If you want start again, please, send me /start';
            $client->sendMessage($message->getChat()->getId(), $text);
        });
    }
}