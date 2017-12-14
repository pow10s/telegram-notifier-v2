<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:09
 */

namespace TelegramNotifier\TelegramChain;


class CommandChain
{
    private $commands = array();

    public function addCommand($commandName)
    {
        $this->commands [] = $commandName;
    }

    public function runCommand($commandName)
    {
        foreach ($this->commands as $command) {
            if ($command->onCommand($commandName)) {
                return;
            }
        }
    }
}