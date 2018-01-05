<?php


namespace TelegramNotifier;

use TelegramNotifier\ServiceContainer\Loader;

class TelegramBot
{
    public function __construct()
    {
        add_action('draft_to_publish', [$this, 'sendPostToTelegram']);
    }

    /**
     * Notify when post created subscribed telegram bot user
     */
    public function sendPostToTelegram()
    {
        try {
            $chats = Loader::resolve('db')->chatAll();
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
                    $text = Loader::resolve('helper')->generate_telegram_post(get_permalink($post['ID']),
                        $post['post_title'],
                        $post['post_content']);
                    $bot = Loader::resolve('botApi');
                    $bot->sendMessage($id->chat_id, $text, 'html', false, null, $keyboard);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Processing bot commands
     */
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
            if (Loader::resolve('helper')->isOptionExist($options, 'admin_enabled') && $options['admin_enabled']) {
                $commandProcessor->addCommand(\TelegramNotifier\TelegramBot\Commands\Admin::class);
            }
            $commandProcessor->commandsHandler();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}