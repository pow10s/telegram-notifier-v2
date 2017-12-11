<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 11.12.17
 * Time: 18:49
 */

namespace TelegramNotifier\TelegramChain;


abstract class TelegramCommandsParser
{
    private $successor;

    public function __construct(TelegramCommandsParser $successor = null)
    {
        $this->successor = $successor;
    }

    public function parse(string $command)
    {
        $successor = $this->getSuccessor();
        if ($successor) {
            $successor->parse($command);
        } else {
            print ('Error, cannot find commands');
        }
    }

    public function getSuccessor()
    {
        return $this->successor;
    }

    public function canHandleCommand(string $command): bool
    {
        if ($command == '/start' || $command == '/search' || $command == '/help') {
            return true;
        }
        return false;
    }
}