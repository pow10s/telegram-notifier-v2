<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 12.12.17
 * Time: 13:08
 */

namespace TelegramNotifier\Factory;


use TelegramNotifier\TelegramChain\CommandParserProcessor;
use TelegramNotifier\Factory\LongPolling;

class TelegramBotFactory extends TelegramFactory
{
    public function initMethod(string $type)
    {
        switch ($type) {
            case parent::LONG_POLLING:
                $long = new LongPolling();
                $long->process();
                break;
            case parent::WEBHOOK:
                echo 'WEBHOOK';
                break;
        }
    }
}