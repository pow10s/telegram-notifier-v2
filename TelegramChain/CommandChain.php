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
    /**
     * @var $api \TelegramBot\Api\
     */
    private $api;

    /**
     * @var $commands array
     */
    private $commands = [];

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * Adding array of commands
     * @param $commandName
     */
    public function addCommand($commandName)
    {
        if ($this->isCommandExist($commandName)) {
            echo 'EXCEPTION';
        } else {
            $this->commands [] = $commandName;
        }
    }

    /**
     * Adding single command
     * @param $commandNames
     */
    public function addCommands($commandNames)
    {
        foreach ($commandNames as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * Get commands
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Run command
     * @param $data
     */
    public function runCommand($data)
    {
        if ($this->getCommands()) {
            foreach ($this->getCommands() as $command) {
                if ($command->make($this->api, $data)) {
                    return;
                }
            }
        }
    }

    /**
     * Check if comamnd exist in array
     * @param $name
     * @return bool
     */
    private function isCommandExist($name): bool
    {
        return (in_array($name, $this->getCommands())) ? true : false;
    }
}