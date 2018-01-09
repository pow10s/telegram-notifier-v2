<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 1:14
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\Message;
use TelegramNotifier\ServiceContainer\Loader;

class Start extends Command
{
    protected $name = 'start';

    protected $description = 'Start work with bot';

    public function handle($arguments)
    {
        $client = $this->client;
        $db = Loader::resolve('db');
        $client->command('start', function (Message $message) use ($client, $db) {
            $db->addContact($message->getChat()->getId());
            $db->resetStatus($message->getChat()->getId());
            $text = 'Hello, thank`s for subscribing. Commands list: /help';
            $client->sendMessage($message->getChat()->getId(), $text);
        });
    }
}