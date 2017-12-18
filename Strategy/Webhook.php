<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 15.12.17
 * Time: 17:03
 */

namespace TelegramNotifier\Strategy;


use TelegramNotifier\TelegramChain\CommandChainProcessor;

class Webhook implements PollingMechanism
{
    private $options;

    public function __construct()
    {
        $this->options = get_option('telegram_bot_options');
    }

    public function process()
    {
        try {
            $client = new \TelegramBot\Api\Client($this->options['bot_token']);
            CommandChainProcessor::run($client, null);
            $client->run();
        } catch (\TelegramBot\Api\Exception $e) {
            echo $e->getMessage();
        }
    }
}