<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 15:19
 */

namespace TelegramNotifier\TelegramBot\Commands;


class Search extends Command
{
    protected $name = 'search';

    protected $description = 'Search command';

    public function handle($arguments)
    {
        $client = $this->client;
        $client->command('search', function ($message) use ($client) {
            $client->sendMessage($message->getChat()->getId(), 'Searching some posts');
        });
    }
}