<?php

namespace TelegramNotifier;


use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\CommandProcessor;
use TelegramNotifier\TelegramDb;
use TelegramNotifier\Helper;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;

$options = get_option('telegram_bot_options');
if (isset($options)) {
    if (array_key_exists('bot_token', $options)) {
        define('BOT_TOKEN', $options['bot_token']);
    }
    if (array_key_exists('admin_enabled', $options)) {
        define('TELEGRAM_ADMIN_PANEL_ENABLED', $options['admin_enabled']);
    }
    if (array_key_exists('verif_code', $options)) {
        define('TELEGRAM_VERIFICATION_CODE', $options['verif_code']);
    }
}

Loader::register('db', function () {
    return new TelegramDb();
});
Loader::register('helper', function () {
    return new Helper();
});
Loader::register('botApi', function () {
    return new BotApi(BOT_TOKEN);
});
Loader::register('commandProcessor', function () {
    return new CommandProcessor(new Client(BOT_TOKEN));
});