<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 22.12.17
 * Time: 14:41
 */

namespace TelegramNotifier\TelegramBot;


use TelegramNotifier\ServiceContainer\Loader;

class LongPolling extends Agregator implements PollingMechanism
{
    protected $offset;

    public function run()
    {
        $this->offset = 0;
        try {
            $response = Loader::resolve('botApi')->getUpdates($this->offset, 60);
            foreach ($response as $data) {
                $this->offset = $response[count($response) - 1]->getUpdateId() + 1;
            }
            $response = Loader::resolve('botApi')->getUpdates($this->offset, 60);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}