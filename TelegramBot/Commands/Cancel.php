<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 10.01.18
 * Time: 16:26
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\Message;
use TelegramNotifier\ServiceContainer\Loader;

class Cancel extends Command
{
    protected $name = 'cancel';

    protected $description = 'Cancel current action';

    public function handle($arguments)
    {
        $client = $this->client;
        $db = Loader::resolve('db');
        $client->command('cancel', function (Message $message) use ($client, $db) {
            $db->resetStatus($message->getChat()->getId());
            $text = 'Current action cancelled';
            $client->sendMessage($message->getChat()->getId(), $text);
        });
    }
}