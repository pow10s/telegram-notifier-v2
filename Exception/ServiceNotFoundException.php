<?php

namespace TelegramNotifier\Exception;


use Interop\Container\Exception\NotFoundException as InteropNotFoundException;

class ServiceNotFoundException extends \Exception implements InteropNotFoundException
{

}