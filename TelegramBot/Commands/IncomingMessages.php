<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 10.01.18
 * Time: 13:58
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\Update;
use TelegramNotifier\ServiceContainer\Loader;

class IncomingMessages extends Command
{
    protected $name = 'incomingMessages';

    public function handle($arguments)
    {
        $client = $this->client;
        $options = get_option('telegram_bot_options');
        $db = Loader::resolve('db');
        $helper = Loader::resolve('helper');
        $client->on(function (Update $update) use ($client, $db, $helper, $options) {
            $chat_id = $update->getMessage()->getChat()->getId();
            $userText = $update->getMessage()->getText();
            $userStatus = $db->getStatus($chat_id);
            switch ($userStatus) {
                case 'admin-verif':
                    if ($options['verif_code'] == $userText) {
                        $text = 'You are logged in. Thanks!';
                        $db->updateAdmin($chat_id);
                        $db->resetStatus($chat_id);
                    } else {
                        $text = 'Incorrect verification code. Please re-type: ';
                    }
                    break;
                case 'admin-post-delete':
                    if (wp_delete_post($userText)) {
                        $text = 'Post was deleted.';
                        $db->resetStatus($chat_id);
                    } else {
                        $text = 'Error. Please re-type Post ID:';
                    }
                    break;
                case 'search-keyword':
                    $posts = $db->searchByKeyword($userText);
                    if ($posts) {
                        $text = '';
                        foreach ($posts as $post) {
                            $text .= $helper->generate_telegram_post(get_permalink($post->ID),
                                    $post->post_title, $post->post_content) . "\n";
                        }
                        $db->resetStatus($chat_id);
                    } else {
                        $text = 'The search did not give a result.';
                        $db->resetStatus($chat_id);
                    }
                    break;
                case 'admin-post':
                    $postContent = explode('::', $userText);
                    if (count($postContent) == 2) {
                        $postData = [
                            'post_status' => 'publish',
                            'post_author' => 1,
                            'post_title' => $postContent[0],
                            'post_content' => $postContent[1],
                        ];
                        $text = 'You are awesome! <b>Post was created</b>';
                        $client->sendMessage($chat_id, $text, 'html');
                        $newPost = wp_insert_post($postData);
                        foreach ($db->chatAll() as $id) {
                            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                                [
                                    [
                                        ['text' => 'Show at the site', 'url' => get_permalink($newPost)]
                                    ]
                                ]
                            );
                            $text = $helper->generate_telegram_post(get_permalink($newPost),
                                $postData['post_title'], $postData['post_content']);
                            $client->sendMessage($id->chat_id, $text, 'html', false, null, $keyboard);
                        }
                        $db->updateStatus($chat_id, 'start');
                    } else {
                        $text = 'Incorrect delimiter, please re-type <b>data( example - TITLE :: BODY)</b>';
                        $client->sendMessage($chat_id, $text, 'html');
                    }
                    break;
                default:
                    $text = 'I don`t understand you. Type /help for commands list.';
                    break;
            }
            //$client->sendMessage($chat_id, $text, 'html');
        }, function (Update $update) {
            return true;
        });
    }
}