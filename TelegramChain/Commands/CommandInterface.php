<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 0:35
 */

namespace TelegramNotifier\TelegramChain\Commands;


interface CommandInterface
{
    public function make($api, $closure);

    public function handle($closure);
}