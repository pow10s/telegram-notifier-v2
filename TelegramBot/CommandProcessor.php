<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 1:33
 */

namespace TelegramNotifier\TelegramBot;


use TelegramBot\Api\Types\Update;
use TelegramNotifier\TelegramBot\Commands\CommandBus;
use TelegramNotifier\ServiceContainer\Loader;

class CommandProcessor
{
    protected $commandBus = null;

    protected $offset;

    protected function processCommands(Update $update)
    {
        $message = $update->getMessage();
        if ($message !== null) {
            $this->getCommandBus()->handler($message->getText(), $update);
        }
    }

    public function getCommandBus()
    {
        if (is_null($this->commandBus)) {
            return $this->commandBus = new CommandBus(Loader::resolve('clientApi'));
        }

        return $this->commandBus;
    }

    public function commandsHandler($webhook = false)
    {
        $client = Loader::resolve('clientApi');
        if (!$webhook) {
            $this->offset = 0;
            $updates = $client->getUpdates($this->offset, 60);
            foreach ($updates as $update) {
                $this->offset = $updates[count($updates) - 1]->getUpdateId() + 1;
                $this->processCommands($update);
            }
            $client->handle($updates);
            $updates = $client->getUpdates($this->offset, 60);
        }
    }

    public function addCommand($name)
    {
        $this->getCommandBus()->addCommand($name);
    }

    public function addCommands($names)
    {
        $this->getCommandBus()->addCommands($names);
    }

}