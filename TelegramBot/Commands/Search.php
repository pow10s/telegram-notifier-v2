<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 15:19
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\Update;
use TelegramNotifier\ServiceContainer\Loader;

class Search extends Command
{
    protected $name = 'search';

    protected $description = 'Search command';

    public function handle($arguments)
    {
        $client = $this->client;
        $client->command('search', function ($message) use ($client) {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                [
                    [
                        ['text' => 'Categories', 'callback_data' => '/search categories'],
                        ['text' => 'Keyword', 'callback_data' => '/search keyword']
                    ]
                ]
            );
            Loader::resolve('db')->updateStatus($message->getChat()->getId(), 'search-keyword');
            $text = 'Search by: ';
            $client->sendMessage($message->getChat()->getId(), $text, null, false, null, $keyboard);
        });
        $client->on(function (Update $update) use ($client, $arguments) {
            if ($arguments == 'categories') {
                $client->sendMessage($update->getCallbackQuery()->getFrom()->getId(), 'searching categories');
            } elseif ($arguments == 'keyword') {
                $client->sendMessage($update->getCallbackQuery()->getFrom()->getId(), 'searching by keywords');
            }
        }, function ($update) {
            return true;
        });
    }
}