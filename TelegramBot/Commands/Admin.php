<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 05.01.18
 * Time: 10:10
 */

namespace TelegramNotifier\TelegramBot\Commands;


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
                            ['text' => 'Create Post', 'callback_data' => 'post-create'],
                            ['text' => 'Delete Post', 'callback_data' => 'post-delete'],
                            ['text' => 'User statistic', 'callback_data' => 'statistic'],
                        ]
                    ]
                );
            }
            $db->updateStatus($message->getChat()->getId(), 'admin');
            $text = 'Welcome, ' . $message->getChat()->getFirstName() . ' ' . $message->getChat()->getLastName() . '  you are in admin panel.';
            $client->sendMessage($message->getChat()->getId(), $text, null, false, null, $keyboard);
        });
        $client->on(function (Update $update) use ($client, $arguments, $db) {
            if ($arguments == 'login') {
                $db->updateStatus($update->getCallbackQuery()->getFrom()->getId(), 'admin-verif');
                $text = 'Insert <b>verification code</b> from your site: ';
                $client->sendMessage($update->getCallbackQuery()->getFrom()->getId(), $text, 'html');
            }
        }, function (Update $update) {
            return true;
        });
    }
}