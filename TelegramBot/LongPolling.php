<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 03.01.18
 * Time: 15:59
 */

namespace TelegramNotifier\TelegramBot;


use TelegramNotifier\ServiceContainer\Loader;

class LongPolling implements PollingMechanism
{
    protected $offset;

    public function run()
    {
        try {
            $this->offset = 0;
            $client = Loader::resolve('clientApi');
            $client->command('stop', function ($message) use ($client) {
                $client->sendMessage($message->getChat()->getId(), 'You have been deleted from bot database');
            });
            $updates = $client->getUpdates($this->offset, 60);
            foreach ($updates as $update) {
                $this->offset = $updates[count($updates) - 1]->getUpdateId() + 1;
            }
            $updates = $client->getUpdates($this->offset, 60);
            $client->handle($updates);

        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}