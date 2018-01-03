<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 03.01.18
 * Time: 19:02
 */

namespace TelegramNotifier\TelegramBot;


use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\PollingMechanism;

class Webhook implements PollingMechanism
{
    public function run()
    {
        $client = Loader::resolve('clientApi');
        $client->run();
    }
}