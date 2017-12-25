<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 22.12.17
 * Time: 14:40
 */

namespace TelegramNotifier\TelegramBot;


use TelegramNotifier\Exception\BotCommandException;
use TelegramNotifier\Helper;

class Agregator
{
    protected $commands = [];

    public function addCommand($command)
    {
        if ($this->isCommandExist($command)) {
            throw new BotCommandException("Command: $command already exist!");
        }
        $this->commands[] = $command;
    }

    public function addCommands(array $commands)
    {
        if ($commands) {
            foreach ($commands as $command) {
                $this->addCommand($command);
            }
        }
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function register()
    {
        if (!Helper::ifNotLocalhostAndSslEnabled()) {
        } else {
            echo 'webhook';
        }
    }

    private function isCommandExist($command): bool
    {
        return (in_array($command, $this->getCommands())) ? true : false;
    }
}