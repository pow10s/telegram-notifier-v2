<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:09
 */

namespace TelegramNotifier\TelegramChain;


interface TCommand
{
    function onCommand($name);
}