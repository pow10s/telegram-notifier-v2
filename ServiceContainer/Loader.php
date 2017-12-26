<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 26.12.17
 * Time: 16:38
 */

namespace TelegramNotifier\ServiceContainer;


class Loader
{
    protected static $registry = [];

    public static function register($name, \Closure $resolve)
    {
        static::$registry[$name] = $resolve;
    }

    public static function resolve($name)
    {
        if (static::registered($name)) {
            $name = static::$registry[$name];
            return $name();
        }
        throw new \Exception('Nothing registered with that name');
    }

    private static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }
}