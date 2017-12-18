<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:09
 */

namespace TelegramNotifier\TelegramChain;


use \TelegramBot\Api\BotApi;
use \TelegramBot\Api\Client;

class CommandChain
{
    private $api;

    private $commands = [];

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function addCommand($commandName)
    {
        if ($this->isCommandExist($commandName)) {
            echo 'EXCEPTION';
        } else {
            $this->commands [] = $commandName;
        }
    }

    public function addCommands($commandNames)
    {
        foreach ($commandNames as $command) {
            $this->addCommand($command);
        }
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function runCommand($closure)
    {
        if ($this->commands) {
            foreach ($this->commands as $command) {
                if ($command->make($this->api, $closure)) {
                    return;
                }
            }
        }
    }

    private function isCommandExist($name): bool
    {
        return (in_array($name, $this->getCommands())) ? true : false;
    }
}