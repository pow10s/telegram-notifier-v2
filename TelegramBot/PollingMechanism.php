<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 22.12.17
 * Time: 14:41
 */

namespace TelegramNotifier\TelegramBot;


interface PollingMechanism
{
    public function run();
}