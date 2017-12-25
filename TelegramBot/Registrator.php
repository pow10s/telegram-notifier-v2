<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 22.12.17
 * Time: 14:45
 */

namespace TelegramNotifier\TelegramBot;


use TelegramNotifier\TelegramBot\Factory\TelegramBotFactory;

class Registrator
{
    protected $agregator;
    protected $factory;

    public function __construct(Agregator $agregator, TelegramBotFactory $factory)
    {
        $this->agregator = $agregator;
        $this->factory = $factory;
    }
}