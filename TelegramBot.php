<?php


namespace TelegramNotifier;

use TelegramNotifier\TelegramDb;
use TelegramNotifier\Helper;

class TelegramBot
{
    protected $options;

    public function __construct()
    {
        $this->options = get_option('telegram_bot_options');
        add_action('draft_to_publish', [$this, 'send_post_to_telegram_users']);
    }

    public function send_post_to_telegram_users()
    {
        $bot = new \TelegramBot\Api\BotApi($this->options['bot_token']);
        $helper = new Helper();
        $db = TelegramDb::chatAll();
        $recent_post = wp_get_recent_posts(['numberposts' => 1]);
        foreach ($db as $id) {
            foreach ($recent_post as $post) {
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                    [
                        [
                            ['text' => 'Show at the site', 'url' => get_permalink($post['ID'])]
                        ]
                    ]
                );
                $text = Helper::generate_telegram_post(get_permalink($post['ID']), $post['post_title'],
                    $post['post_content']);
                $bot->sendMessage($id->chat_id, $text, 'html', false, null, $keyboard);
            }
        }
    }
}