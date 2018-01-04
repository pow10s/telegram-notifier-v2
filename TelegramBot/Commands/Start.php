<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 1:14
 */

namespace TelegramNotifier\TelegramBot\Commands;


class Start extends Command
{
    protected $name = 'start';

    protected $description = 'Starting command';

    public function handle($arguments)
    {
        $client = $this->client;
        $client->command('start', function ($message) use ($client) {
            $client->sendMessage($message->getChat()->getId(), 'Hello world');
        });
    }
}