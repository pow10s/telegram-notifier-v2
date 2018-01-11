<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 15:19
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramBot\Api\Types\CallbackQuery;
use TelegramBot\Api\Types\Update;
use TelegramNotifier\ServiceContainer\Loader;

class Search extends Command
{
    protected $name = 'search';

    protected $description = 'Search posts';

    public function handle($arguments)
    {
        $client = $this->client;
        $helper = Loader::resolve('helper');
        $db = Loader::resolve('db');
        $client->command('search', function ($message) use ($client, $db) {
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                [
                    [
                        ['text' => 'Categories', 'callback_data' => '/search categories'],
                        ['text' => 'Keyword', 'callback_data' => '/search keyword']
                    ]
                ]
            );
            $db->updateStatus($message->getChat()->getId(), 'search');
            $text = 'Search by: ';
            $client->sendMessage($message->getChat()->getId(), $text, null, false, null, $keyboard);
        });
        $client->callbackQuery(function (CallbackQuery $callbackQuery) use ($client, $arguments, $helper, $db) {
            $callbackId = $callbackQuery->getFrom()->getId();
            switch ($arguments) {
                case 'categories':
                    if ($helper->get_categories_buttons_list('/search')) {
                        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($helper->get_categories_buttons_list('/search'));
                        $db->updateStatus($callbackId, 'search-categories');
                        $text = 'List of categories: ';
                        $client->sendMessage($callbackId, $text, null, false, null, $keyboard);
                    } else {
                        $db->resetStatus($callbackId);
                        $text = 'At that moment you haven`t created categories ';
                        $client->sendMessage($callbackId, $text, null, false, null, null);
                    }
                    break;
                case 'keyword':
                    $db->updateStatus($callbackId, 'search-keyword');
                    $text = 'Please, type <b>keyword</b> and you will get list of posts:';
                    $client->sendMessage($callbackId, $text, 'html');
                    break;
            }
            foreach (get_categories() as $category) {
                if ($arguments == $category->term_id) {
                    $posts = get_posts(['category' => $category->term_id]);
                    $text = '';
                    if ($posts) {
                        foreach ($posts as $post) {
                            $text .= $helper->generate_telegram_post(get_permalink($post->ID), $post->post_title, $post->post_content) . "\n";
                        }
                        $db->resetStatus($callbackId);
                        $client->sendMessage($callbackId, $text, 'html');
                    } else {
                        $text = 'There are no posts in this category';
                        $client->sendMessage($callbackId, $text);
                    }
                }
            }
            $client->answerCallbackQuery($callbackQuery->getId());
        });
    }
}