<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 21.12.17
 * Time: 16:24
 */

namespace TelegramNotifier\Container;


interface ContainerInterface
{
    public function get($id);

    public function set($id);
}