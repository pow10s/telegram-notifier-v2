<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 15.12.17
 * Time: 16:34
 */

namespace TelegramNotifier\Strategy;


use TelegramNotifier\Strategy\LongPolling;
use TelegramNotifier\Strategy\Webhook;

class PollingManager
{
    const WEBHOOK = 'webhook';
    const LONG_POLLING = 'long_polling';

    public function getPolling($methodType)
    {
        switch ($methodType) {
            case PollingManager::LONG_POLLING:
                return new LongPolling();
                break;
            case PollingManager::WEBHOOK:
                return new Webhook();
                break;
        }
    }
}