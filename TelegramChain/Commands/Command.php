<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 0:37
 */

namespace TelegramNotifier\TelegramChain\Commands;


abstract class Command implements CommandInterface
{
    protected $name;

    protected $description;

    protected $api;

    public function getName()
    {
        return $this->name;
    }

    public function getApi()
    {
        return $this->api;
    }

    public function getDecription()
    {
        return $this->description;
    }

    public function make($api, $closure)
    {
        $this->api = $api;
        return $this->handle($closure);
    }

    abstract public function handle($closure);
}