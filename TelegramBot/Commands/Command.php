<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 03.01.18
 * Time: 18:18
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\TelegramBot\Commands\CommandInterface;

abstract class Command implements CommandInterface
{
    protected $name;

    protected $client;

    protected $description;

    protected $update;

    protected $arguments;

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function make($client, $arguments, $update)
    {
        $this->client = $client;
        $this->arguments = $arguments;
        $this->update = $update;
        return $this->handle($arguments);
    }

    abstract public function handle($arguments);
}