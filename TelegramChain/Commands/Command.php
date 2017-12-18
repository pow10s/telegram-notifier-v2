<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 18.12.17
 * Time: 0:37
 */

namespace TelegramNotifier\TelegramChain\Commands;


abstract class Command implements CommandInterface
{
    /**
     * Command name
     * @var $name
     */
    protected $name;

    /**
     * Command description
     * @var $description
     */
    protected $description;

    /**
     * Bot api
     * @var $api
     */
    protected $api;

    /**
     * Get command name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *Get Bot Api
     * @return mixed
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Get command description
     * @return mixed
     */
    public function getDecription()
    {
        return $this->description;
    }

    /**
     * @uses CommandInterface
     * @param $api
     * @param $data
     * @return mixed
     */
    public function make($api, $data)
    {
        $this->api = $api;
        return $this->handle($data);
    }

    /**
     * @uses CommandInterface
     * @param $data
     * @return mixed
     */
    abstract public function handle($data);
}