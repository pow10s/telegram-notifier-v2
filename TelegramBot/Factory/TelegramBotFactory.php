<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 25.12.17
 * Time: 16:36
 */

namespace TelegramNotifier\TelegramBot\Factory;


use TelegramNotifier\Exception\BotCommandException;
use TelegramNotifier\TelegramBot\LongPolling;
use TelegramNotifier\TelegramBot\Webhook;

class TelegramBotFactory
{
    const WEBHOOK = 'webhook';
    const LONG_POLLIN = 'long_polling';

    public function factory($type)
    {
        switch ($type) {
            case TelegramBotFactory::LONG_POLLIN:
                $object = new LongPolling();
                break;
            case TelegramBotFactory::WEBHOOK:
                $object = new Webhook();
                break;
            default:
                throw new BotCommandException("Factory can't create bot of specific type: $type");
                break;
        }
        return $object;
    }
}