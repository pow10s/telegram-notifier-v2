<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 21.12.17
 * Time: 16:39
 */

namespace TelegramNotifier\Container;


use Interop\Container\ContainerInterface as InteropContainerInterface;
use TelegramNotifier\Container\Reference\ParameterReference;
use TelegramNotifier\Container\Reference\ServiceReference;
use TelegramNotifier\Exception\ContainerException;
use TelegramNotifier\Exception\ParameterNotFoundException;
use TelegramNotifier\Exception\ServiceNotFoundException;

class Container implements InteropContainerInterface
{
    private $services;
    private $parameters;
    private $serviceStore;

    public function __construct(array $services = [], array $parameters = [])
    {
        $this->services = $services;
        $this->parameters = $parameters;
        $this->serviceStore = [];
    }

    public function get($name)
    {
        if (!$this->has($name)) {
            throw new ServiceNotFoundException('Service not found:' . $name);
        }

        if (!isset($this->serviceStore[$name])) {
            $this->serviceStore[$name] = $this->createService($name);
        }

        return $this->serviceStore[$name];
    }

    public function getParameter($name)
    {
        $tokens = explode('.', $name);
        $context = $this->parameters;
        $token = array_shift($tokens);
        while (!null == $token) {
            if (!isset($context[$token])) {
                throw new ParameterNotFoundException('Parameter not found:' . $name);
            }
            $context = $context[$token];
        }
        return $context;
    }

    public function has($name)
    {
        return isset($this->services[$name]);
    }

    private function createService($name)
    {
        $entry = &$this->services[$name];
        if (!is_array($entry) || !isset($entry['class'])) {
            throw new ContainerException($name . 'service entry must be an array containing a \'class\' ');
        } elseif (!class_exists($entry['class'])) {
            throw new ContainerException($name . 'service class does not exist:' . $entry['class']);
        } elseif (isset ($entry['lock'])) {
            throw new ContainerException($name . 'service container a circular reference');
        }
        $entry['lock'] = true;
        $arguments = isset($entry['arguments']) ? $this->resolveArguments($name, $entry['arguments']) : [];
        $reflector = new \ReflectionClass($entry['class']);
        $service = $reflector->newInstanceArgs($arguments);
        if (isset($entry['calls'])) {
            $this->initializeService($service, $name, $entry['calls']);
        }
        return $service;
    }

    private function resolveArguments($name, array $argumetDefinitions)
    {
        $arguments = [];
        foreach ($argumetDefinitions as $argumetDefinition) {
            if ($argumetDefinition instanceof ServiceReference) {
                $argumentServiceName = $argumetDefinition->getName();
                $arguments[] = $this->get($argumentServiceName);
            } elseif ($argumetDefinition instanceof ParameterReference) {
                $argumentParameterName = $argumetDefinition->getName();
                $arguments[] = $this->getParameter($argumentParameterName);
            } else {
                $arguments[] = $argumetDefinition;
            }
        }
        return $arguments;
    }

    private function initializeService($service, $name, array $callDefinitions)
    {
        foreach ($callDefinitions as $callDefinition) {
            if (!is_array($callDefinition) || !isset($callDefinition['method'])) {
                throw new ContainerException($name . ' service calls must be arrays containing a \'method\' key');
            } elseif (!is_callable([$service, $callDefinition['method']])) {
                throw new ContainerException($name . ' service asks for call to uncallable method: ' . $callDefinition['method']);
            }
            $arguments = isset($callDefinition['arguments']) ? $this->resolveArguments($name,
                $callDefinition['arguments']) : [];
            call_user_func_array([$service, $callDefinition['method']], $arguments);
        }
    }
}