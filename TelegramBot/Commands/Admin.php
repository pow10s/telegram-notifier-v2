<?php

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\CallbackQuery;
use TelegramBot\Api\Types\Message;
use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\Commands\Command;

class Admin extends Command
{
    protected $name = 'admin';

    protected $description = 'show admin-panel';

    public function handle($arguments)
    {
        $client = $this->client;
        $helper = Loader::resolve('helper');
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
        $client->callbackQuery(function (CallbackQuery $callbackQuery) use ($client, $arguments, $db, $helper) {
            $callbackId = $callbackQuery->getFrom()->getId();
            switch ($arguments) {
                case 'login':
                    $text = 'Insert <b>verification code</b> from your site: ';
                    $db->updateStatus($callbackId, 'admin-verif');
                    $client->editMessageReplyMarkup($callbackQuery->getMessage()->getChat()->getId(),
                        $callbackQuery->getMessage()->getMessageId());
                    break;
                case 'post-create':
                    $text = 'Send me, please, your <b>post data</b>( example - TITLE :: BODY): ';
                    $db->updateStatus($callbackId, 'admin-post');
                    break;
                case 'post-delete':
                    $posts = get_posts(['numberposts' => 0]);
                    $text = 'Please choose post ID which you want to delete from list below: ' . "\n";
                    if ($posts) {
                        foreach ($posts as $post) {
                            $text .= $helper->generate_telegram_post(get_permalink($post),
                                    $post->post_title,
                                    'ID -> ' . $post->ID) . "\n";
                        }
                        $db->updateStatus($callbackId, 'admin-post-delete');
                    } else {
                        $db->resetStatus($callbackId);
                        $text = 'You havent created posts :(';
                    }
                    break;
                case 'statistic':
                    $db->resetStatus($callbackId);
                    $allusers = count($db->chatAll());
                    $text = 'Current users: ' . $allusers;
                    break;
            }
            $client->sendMessage($callbackId, $text, 'html');
            $client->answerCallbackQuery($callbackQuery->getId());
        });
    }
}