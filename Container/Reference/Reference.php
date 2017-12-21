<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 21.12.17
 * Time: 16:34
 */

namespace TelegramNotifier\Container\Reference;


abstract class Reference
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}