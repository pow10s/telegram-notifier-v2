<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 03.01.18
 * Time: 18:18
 */

namespace TelegramNotifier\TelegramBot\Commands;


use TelegramNotifier\TelegramBot\Commands\CommandInterface;

abstract class Command implements CommandInterface
{
    /** Command name
     * @var $name
     */
    protected $name;

    /**Api
     * @var $client \TelegramBot\Api\Client
     */
    protected $client;

    /** Command description
     * @var $description
     */
    protected $description;

    /** Update
     * @var $update \TelegramBot\Api\Types\Update
     */
    protected $update;

    /** Command args
     * @var $arguments
     */
    protected $arguments;

    /** Get command name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /** Get command description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /** Process inbound command
     * @param $client
     * @param $arguments
     * @param $update
     * @return mixed
     */
    public function make($client, $arguments, $update)
    {
        $this->client = $client;
        $this->arguments = $arguments;
        $this->update = $update;
        return $this->handle($arguments);
    }

    /** Process the command
     * @param $arguments
     * @return mixed
     */
    abstract public function handle($arguments);
}