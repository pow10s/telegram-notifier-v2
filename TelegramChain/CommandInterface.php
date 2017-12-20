<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 0:35
 */

namespace TelegramNotifier\TelegramChain;


interface CommandInterface
{
    /**
     * Processing command
     * @param $api
     * @param $closure
     * @return mixed
     */
    public function make($api, $data);

    /**
     * Command hanler
     * @param $data
     * @return mixed
     */
    public function handle($data);
}