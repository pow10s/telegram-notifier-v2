<?php


namespace TelegramNotifier;

use TelegramNotifier\ServiceContainer\Loader;

class TelegramBot
{
    protected $helper;

    public function __construct()
    {
        $this->helper = Loader::resolve('helper');
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
                    $text = $this->helper->generate_telegram_post(get_permalink($post['ID']), $post['post_title'],
                        $post['post_content']);
                    $bot = Loader::resolve('botApi');
                    $bot->sendMessage($id->chat_id, $text, 'html', false, null, $keyboard);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function process()
    {
        try {
            $options = get_option('telegram_bot_options');
            $commandProcessor = Loader::resolve('commandProcessor');
            $commandProcessor->addCommands([
                \TelegramNotifier\TelegramBot\Commands\Help::class,
                \TelegramNotifier\TelegramBot\Commands\Start::class,
                \TelegramNotifier\TelegramBot\Commands\Stop::class,
                \TelegramNotifier\TelegramBot\Commands\Search::class,
            ]);
            if ($this->helper->isOptionExist($options, 'admin_enabled') && $options['admin_enabled']) {
                $commandProcessor->addCommand(\TelegramNotifier\TelegramBot\Commands\Admin::class);
            }
            $commandProcessor->commandsHandler();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}