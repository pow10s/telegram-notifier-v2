<?php

namespace TelegramNotifier;


use TelegramNotifier\ServiceContainer\Loader;

class TelegramBot
{
    public function __construct()
    {
        add_action('draft_to_publish', [$this, 'sendPostToTelegram']);
        if (Loader::resolve('helper')->ifNotLocalhostAndSslEnabled()) {
            if (isset($_POST['webhook_enabled'])) {
                add_action('init', [$this, 'setWebhook']);
            } elseif (isset($_POST['webhook_disabled'])) {
                add_action('init', [$this, 'unsetWebhook']);
            }
        }
        add_action('init', [$this, 'process']);
    }

    /**
     * Notify subscribed telegram bot user when post created
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
            $commandProcessor = Loader::resolve('commandProcessor');
            $commandProcessor->addCommands([
                \TelegramNotifier\TelegramBot\Commands\IncomingMessages::class,
                \TelegramNotifier\TelegramBot\Commands\Help::class,
                \TelegramNotifier\TelegramBot\Commands\Start::class,
                \TelegramNotifier\TelegramBot\Commands\Stop::class,
                \TelegramNotifier\TelegramBot\Commands\Search::class,
                \TelegramNotifier\TelegramBot\Commands\Cancel::class
            ]);
            if (defined('TELEGRAM_ADMIN_PANEL_ENABLED') && TELEGRAM_ADMIN_PANEL_ENABLED) {
                $commandProcessor->addCommand(\TelegramNotifier\TelegramBot\Commands\Admin::class);
            }
            $pollingMethod = Loader::resolve('helper')->ifNotLocalhostAndSslEnabled();
            $commandProcessor->commandsHandler($pollingMethod);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function setWebhook()
    {
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'telegram-settings') {
            $bot = Loader::resolve('botApi');
            $pluginUrl = plugins_url('telegram-notifier-v2/TelegramNotifier.php');
            $bot->setWebhook($pluginUrl);
        }
    }

    protected function unsetWebhook()
    {
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'telegram-settings') {
            $bot = Loader::resolve('botApi');
            $bot->setWebhook('');
        }
    }
}