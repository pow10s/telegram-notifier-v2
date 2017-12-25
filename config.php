<?php

namespace TelegramNotifier;


use TelegramNotifier\TelegramBot\Agregator;
use TelegramNotifier\TelegramDb;
use TelegramNotifier\Helper;
use \TelegramBot\Api\BotApi;
use \TelegramBot\Api\Client;

return [
    TelegramDb::class => [
        'class' => TelegramDb::class,
    ],
    Helper::class => [
        'class' => Helper::class
    ],
    BotApi::class => [
        'class' => BotApi::class,
    ],
    Client::class => [
        'class' => Client::class
    ],
    Agregator::class => [
        'class' => Agregator::class
    ]
];
