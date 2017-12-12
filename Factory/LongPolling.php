<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 12.12.17
 * Time: 13:37
 */

namespace TelegramNotifier\Factory;


use TelegramNotifier\TelegramChain\CommandParserProcessor;

class LongPolling
{
    private $offset;

    public function process()
    {
        try {
            $this->offset = 0;
            $botApi = new \TelegramBot\Api\BotApi('438332110:AAFCgeVIz_vq6HJznmLqbvTcxbZ0v4lCEzY');
            $responce = $botApi->getUpdates($this->offset, 60);
            foreach ($responce as $data) {
                if ($data->getMessage()) {
                    CommandParserProcessor::runCommands($data->getMessage()->getText());
                }
                $this->offset = $responce[count($responce) - 1]->getUpdateId() + 1;
            }
            $responce = $botApi->getUpdates($this->offset, 60);
        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }
    }
}