<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 12.12.17
 * Time: 13:05
 */

namespace TelegramNotifier\Factory;


abstract class TelegramFactory
{
    const LONG_POLLING = 'long_polling';
    const WEBHOOK = 'webhook';

    abstract protected function initMethod(string $type);
}