<?php

namespace TelegramNotifier;


use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\CommandProcessor;
use TelegramNotifier\TelegramDb;
use TelegramNotifier\Helper;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;

$options = get_option('telegram_bot_options');
$token = $options['bot_token'];

Loader::register('db', function () {
    return new TelegramDb();
});
Loader::register('helper', function () {
    return new Helper();
});
Loader::register('clientApi', function () use ($token) {
    return new Client($token);
});
Loader::register('botApi', function () use ($token) {
    return new BotApi($token);
});
Loader::register('commandProcessor', function () use ($token) {
    return new CommandProcessor(new Client($token));
});