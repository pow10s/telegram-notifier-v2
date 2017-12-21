<?php

namespace TelegramNotifier;


use TelegramNotifier\Container\Container;

class ContainerInitializator
{
    public static function init()
    {
        $services = include __DIR__.'/config.php';
        return new Container($services);
    }
}


