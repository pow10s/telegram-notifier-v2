<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 1:59
 */

namespace TelegramNotifier\TelegramBot\Commands;


class Stop extends Command
{
    protected $name = 'stop';

    public function handle($arguments)
    {
        $client = $this->client;
        $client->command('stop', function ($message) use ($client) {
            $client->sendMessage($message->getChat()->getId(), 'Stopped work with bot');
        });
    }
}