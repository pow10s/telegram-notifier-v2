<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 0:35
 */

namespace TelegramNotifier\TelegramBot\Commands;


interface CommandInterface
{
    public function runCommand($command);
}