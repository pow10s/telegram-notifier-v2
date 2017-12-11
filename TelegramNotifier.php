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

use TelegramNotifier\TelegramChain\TelegramCommandsProcessor;

if (!defined('ABSPATH')) {
    //If wordpress isn't loaded load it up.
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once $path . '/wp/wp-load.php';
}
define('TELEGRAM_NOTIFIER_PLUGIN_DIR', plugin_dir_path(__FILE__));
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class TelegramNotifier
{
    public function __construct()
    {
        if (is_admin()) {
            $db = new \TelegramNotifier\TelegramDb();
            $settingsPage = new \TelegramNotifier\TelegramMenu();
            register_activation_hook(__FILE__, [$db, 'create_table']);
            register_deactivation_hook(__FILE__, [$db, 'delete_table']);

            TelegramCommandsProcessor::run(['/help', '/start']);
        }
    }
}
$plugin = new TelegramNotifier();