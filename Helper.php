<?php

namespace TelegramNotifier;

/**
 * Helper Class
 * @version 0.1.0
 */
class Helper
{
    /**
     * Transform categories list in keyboard for telegram bot
     * @return array|bool $keyboard
     */
    public function get_categories_buttons_list()
    {
        if (get_categories()) {
            $keyboard = [];
            foreach (get_categories() as $category) {
                $keyboard[] =
                    [
                        ['text' => $category->name, 'callback_data' => $category->term_id]
                    ];
            }
            return $keyboard;
        } else {
            return false;
        }
    }

    /**
     * Generate telegram post in HTML markdown @link https://core.telegram.org/bots/api#markdown-style
     * @param string $postUrl
     * @param string $postTitle
     * @param string $postBody
     * @return string
     */
    public static function generate_telegram_post(string $postUrl, string $postTitle, string $postBody): string
    {
        return '<a href=' . '"' . $postUrl . '"' . '>' . $postTitle . '</a>' . strip_tags("\n" . substr("$postBody", 0,
                    400));
    }

    /**
     * Random string generator
     * @param int $length
     * @return string
     */
    public function randomString(int $length = 8): string
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**
     * Check if server not on localhost environment and SSL enabled
     * @return bool
     */
    public static function ifNotLocalhostAndSslEnabled(): bool
    {
        return ($_SERVER["SERVER_ADDR"] == '127.0.0.1' || !is_ssl()) ? false : true;
    }

    /**
     * Check if wordpress option exists
     * @param $option
     * @param $arrayOfOptions
     * @param $optionName
     * @return bool
     */
    public static function isOptionExist($arrayOfOptions, $optionName): bool
    {
        return (isset($arrayOfOptions) && array_key_exists($optionName, $arrayOfOptions)) ? true : false;
    }

    public static function getPostsIfExist()
    {
        $posts = get_posts(['numberposts' => 0]);
        return ($posts) ? $posts : false;
    }
}