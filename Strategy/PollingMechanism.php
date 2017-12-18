<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 15.12.17
 * Time: 16:33
 */

namespace TelegramNotifier\Strategy;


interface PollingMechanism
{
    function process();
}