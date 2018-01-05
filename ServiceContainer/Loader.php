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
    /**Container of registered objects
     * @var array
     */
    protected static $registry = [];

    /**Register object
     * @param $name
     * @param \Closure $resolve
     */
    public static function register($name, \Closure $resolve)
    {
        static::$registry[$name] = $resolve;
    }

    /**Resolve registered object
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public static function resolve($name)
    {
        if (static::registered($name)) {
            $name = static::$registry[$name];
            return $name();
        }
        throw new \Exception('Nothing registered with that name');
    }

    /**Check if object registered
     * @param $name
     * @return bool
     */
    private static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }
}