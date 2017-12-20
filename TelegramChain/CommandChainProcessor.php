<?php
/**
 * Created by PhpStorm.
 * User: stosdima
 * Date: 14.12.17
 * Time: 18:25
 */

namespace TelegramNotifier\TelegramChain;


use TelegramNotifier\TelegramChain\CallbackqueryCommands\CreatePost;
use TelegramNotifier\TelegramChain\CallbackqueryCommands\DeletePost;
use TelegramNotifier\TelegramChain\CallbackqueryCommands\Login;
use TelegramNotifier\TelegramChain\CallbackqueryCommands\SearchByCategories;
use TelegramNotifier\TelegramChain\CallbackqueryCommands\SearchByKeyword;
use TelegramNotifier\TelegramChain\CallbackqueryCommands\Statistic;
use TelegramNotifier\TelegramChain\Commands\Admin;
use TelegramNotifier\TelegramChain\Commands\Help;
use TelegramNotifier\TelegramChain\Commands\Search;
use TelegramNotifier\TelegramChain\Commands\Start;
use TelegramNotifier\TelegramChain\Commands\Stop;

class CommandChainProcessor
{
    const COMMAND = 'command';

    const CALLBACKQUERY = 'callbackquery';

    /**
     * Command runner
     * @param $api
     * @param null $data
     * @param string|null $dataType
     */
    public static function run($api, $data = null, string $dataType = null)
    {
        $cc = new CommandChain($api);
        switch ($dataType) {
            case CommandChainProcessor::COMMAND:
                $commands = [
                    new Start(),
                    new Stop(),
                    new Help(),
                    new Search(),
                    new Admin(),
                ];
                break;
            case CommandChainProcessor::CALLBACKQUERY:
                $commands = [
                    new SearchByCategories(),
                    new SearchByKeyword(),
                    new Login(),
                    new CreatePost(),
                    new DeletePost(),
                    new Statistic(),
                ];
                break;
        }
        $cc->addCommands($commands);
        $cc->runCommand($data);
    }
}