<?php

namespace TelegramNotifier\Strategy;


use TelegramNotifier\TelegramChain\CommandChainProcessor;

class LongPolling implements PollingMechanism
{
    private $offset;

    private $options;

    public function __construct()
    {
        $this->options = get_option('telegram_bot_options');
    }

    /**
     * @uses PollingMechanism
     */
    public function process()
    {
        try {
            $this->offset = 0;
            $botApi = new \TelegramBot\Api\BotApi($this->options['bot_token']);
            $responce = $botApi->getUpdates($this->offset, 60);
            foreach ($responce as $data) {
                if ($data->getMessage()) {
                    CommandChainProcessor::run($botApi, $data, CommandChainProcessor::COMMAND);
                } elseif ($data->getCallbackQuery()) {
                    CommandChainProcessor::run($botApi, $data, CommandChainProcessor::CALLBACKQUERY);
                }
                $this->offset = $responce[count($responce) - 1]->getUpdateId() + 1;
            }
            $response = $botApi->getUpdates($this->offset, 60);
        } catch (\TelegramBot\Api\Exception $e) {
            echo $e->getMessage();
        }

    }
}