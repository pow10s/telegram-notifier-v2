<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 17:39
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\ServiceContainer\Loader;

class Help extends Command
{
    protected $name = 'help';

    protected $description = 'Show command`s list';

    public function handle($arguments)
    {
        $client = $this->client;
        $client->command('help', function ($message) use ($client) {
            $client->sendMessage($message->getChat()->getId(), 'Commands list');
        });
    }
}