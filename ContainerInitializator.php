<?php

namespace TelegramNotifier;


use TelegramNotifier\Container\Container;

class ContainerInitializator
{
    public static function run()
    {
        $services = include __DIR__ . '/config.php';
        $parameters = include  __DIR__ . '/params.php';
        return new Container($services, $parameters);
    }
}
