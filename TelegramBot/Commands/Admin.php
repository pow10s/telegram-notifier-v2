<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 05.01.18
 * Time: 10:10
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\CallbackQuery;
use TelegramBot\Api\Types\Inline\QueryResult\Photo;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\Commands\Command;

class Admin extends Command
{
    protected $name = 'admin';

    protected $description = 'show admin-panel';

    public function handle($arguments)
    {
        $client = $this->client;
        $db = Loader::resolve('db');
        $client->command('admin', function (Message $message) use ($client, $db) {
            if (!$db->isAdmin($message->getChat()->getId())) {
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                    [
                        [
                            ['text' => 'Login', 'callback_data' => '/admin login'],
                        ]
                    ]
                );
            } else {
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                    [
                        [
                            ['text' => 'Create Post', 'callback_data' => '/admin post-create'],
                            ['text' => 'Delete Post', 'callback_data' => '/admin post-delete'],
                            ['text' => 'User statistic', 'callback_data' => '/admin statistic'],
                        ]
                    ]
                );
            }
            $text = 'Welcome, ' . $message->getChat()->getFirstName() . ' ' . $message->getChat()->getLastName() . ', you are in admin panel.';
            $client->sendMessage($message->getChat()->getId(), $text, null, false, null, $keyboard);
        });
        $client->callbackQuery(function (CallbackQuery $callbackQuery) use ($client, $arguments) {
            $callbackId = $callbackQuery->getFrom()->getId();
            if ($arguments == 'login') {
                $text = 'Insert <b>verification code</b> from your site: ';
                $client->sendMessage($callbackId, $text, 'html');
            }
        });
    }
}