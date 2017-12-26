<?php


namespace TelegramNotifier;

use TelegramNotifier\ServiceContainer\Loader;

class TelegramBot
{
    public function __construct()
    {
        add_action('draft_to_publish', [$this, 'send_post_to_telegram_users']);
    }

    public function send_post_to_telegram_users()
    {
        try {
            $db = Loader::resolve('db');
            $chats = $db->chatAll();
            $recent_post = wp_get_recent_posts(['numberposts' => 1]);
            foreach ($chats as $id) {
                foreach ($recent_post as $post) {
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                        [
                            [
                                ['text' => 'Show at the site', 'url' => get_permalink($post['ID'])]
                            ]
                        ]
                    );
                    $helper = Loader::resolve('helper');
                    $text = $helper->generate_telegram_post(get_permalink($post['ID']), $post['post_title'],
                        $post['post_content']);
                    $bot = Loader::resolve('botApi');
                    $bot->sendMessage($id->chat_id, $text, 'html', false, null, $keyboard);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}