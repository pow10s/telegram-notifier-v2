<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 18:07
 */

namespace TelegramNotifier\TelegramChain\Commands;


use TelegramBot\Api\BotApi;
use TelegramNotifier\Helper;
use TelegramNotifier\TelegramChain\Command;
use TelegramNotifier\TelegramDb;

class Search extends Command
{
    protected $name = '/search';

    protected $description = 'Search by: ';

    public function handle($data)
    {
        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
            [
                [
                    ['text' => 'Categories', 'callback_data' => 'categories'],
                    ['text' => 'Keyword', 'callback_data' => 'login'],
                ]
            ]
        );
        if (Helper::isLongPolling($data, $this->api, BotApi::class)) {
            if ($data->getMessage()->getText() == $this->getName()) {
                $chatId = $data->getMessage()->getChat()->getId();
                TelegramDb::updateStatus($chatId, 'search-keyword');
                $this->getApi()->sendMessage($chatId, $this->getDecription(), 'html', false, null, $keyboard);
            }
        } else {
            $bot = $this->api;
            $bot->command($this->getDecription(), function ($message) use ($bot, $keyboard) {
                $chatId = $message->getChat()->getId();
                TelegramDb::updateStatus($chatId, 'search-keyword');
                $bot->sendMessage($chatId, $this->getDecription(), null, false, null, $keyboard);
            });
        }
    }

    public function make($api, $data)
    {
        return parent::make($api, $data); // TODO: Change the autogenerated stub
    }
}