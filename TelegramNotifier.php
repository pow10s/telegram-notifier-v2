<?php

namespace TelegramNotifier;


/**
 * Plugin Name: Telegram Notifier V2
 * Plugin URI: some href
 * Description: <strong>some description</strong>
 * Version: 0.1
 * Author: Stos Dima
 * Author URI: stosdima@gmail.com
 * License: MIT
 */

use TelegramNotifier\ServiceContainer\Loader;
use TelegramNotifier\TelegramBot\LongPolling;

if (!defined('ABSPATH')) {
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once $path . '/wp/wp-load.php';
}

if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once(__DIR__ . '/config.php');

class TelegramNotifier
{
    public function __construct()
    {
        if (is_admin()) {
            $db = Loader::resolve('db');
            $settingsPage = new \TelegramNotifier\TelegramMenu();
            register_activation_hook(__FILE__, [$db, 'create_table']);
            register_deactivation_hook(__FILE__, [$db, 'delete_table']);
            $bot = new TelegramBot();
            $lp = new LongPolling();
            $lp->run();

        }
    }
}

$plugin = new TelegramNotifier();