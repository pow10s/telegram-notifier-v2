<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 03.01.18
 * Time: 15:58
 */

namespace TelegramNotifier\TelegramBot;


interface PollingMechanism
{
    public function run();
}