<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 04.01.18
 * Time: 1:33
 */

namespace TelegramNotifier\TelegramBot;


use TelegramBot\Api\Exception;
use TelegramBot\Api\Types\Update;
use TelegramNotifier\TelegramBot\Commands\CommandBus;

class CommandProcessor
{
    /**Telegram Bot Api
     * @var \TelegramBot\Api\Client $client
     */
    protected $client;

    /**
     * @var null $commandBus
     */
    protected $commandBus = null;

    /**
     * @var $offset
     */
    protected $offset;

    public function __construct(\TelegramBot\Api\Client $client)
    {
        $this->client = $client;
    }

    /**Getting CommandsBus
     * @return null|CommandBus
     * @throws \Exception
     */
    protected function getCommandBus()
    {
        if (is_null($this->commandBus)) {
            return $this->commandBus = new CommandBus($this->client);
        }

        return $this->commandBus;
    }

    /**
     * @param Update $update
     * @throws \Exception
     */
    protected function processCommands(Update $update)
    {
        $message = $update->getMessage();
        $callbackQuery = $update->getCallbackQuery();
        if ($message !== null && $message->getText()) {
            $this->getCommandBus()->handler($message->getText(), $update);
        } elseif ($callbackQuery !== null && $update->getCallbackQuery()) {
            $this->getCommandBus()->handler($callbackQuery->getData(), $update);
        }
    }

    /**Incoming commands handler
     * @param bool $webhook
     * @throws \Exception
     */
    public function commandsHandler($webhook = false)
    {
        if (!$webhook) {
            $this->offset = 0;
            $updates = $this->client->getUpdates($this->offset, 60);
            foreach ($updates as $update) {
                $this->offset = $updates[count($updates) - 1]->getUpdateId() + 1;
                $this->processCommands($update);
            }
            $this->client->handle($updates);
            $updates = $this->client->getUpdates($this->offset, 60);
        } else {
            $this->client->run();
        }
    }

    /**Command adder
     * @param $name
     * @throws \Exception
     * @throws \TelegramNotifier\Exception\BotCommandException
     */
    public function addCommand($name)
    {
        $this->getCommandBus()->addCommand($name);
    }

    /**Commands adder
     * @param $names
     * @throws \Exception
     */
    public function addCommands($names)
    {
        $this->getCommandBus()->addCommands($names);
    }

    /**Getting exists commands
     * @return array
     * @throws \Exception
     */
    public function getCommands()
    {
        return $this->getCommandBus()->getCommands();
    }
}