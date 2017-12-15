<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 15.12.17
 * Time: 17:03
 */

namespace TelegramNotifier\Strategy;


class Webhook implements PollingMechanism
{
    public function process()
    {
        echo 2;
    }
}