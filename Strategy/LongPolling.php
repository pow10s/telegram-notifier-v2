<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 15.12.17
 * Time: 16:59
 */

namespace TelegramNotifier\Strategy;


class LongPolling implements PollingMechanizm
{
    public function process()
    {
        echo 1;
    }
}