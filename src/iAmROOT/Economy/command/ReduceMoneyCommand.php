<?php
declare(strict_types=1);

namespace iAmROOT\Economy\command;

use iAmROOT\Economy\API;
use iAmROOT\Economy\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class ReduceMoneyCommand extends Command{
    public function __construct(string $name, string $description = "", ?string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission('reduce.money.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!isset($args[0]) || !isset($args[1])){
            return;
        }
        if(!is_string($args[0]) && !is_numeric($args[1])){
            return;
        }

        $player = Loader::getInstance()->getServer()->getPlayer($args[0]);
        if($player === null){
            return;
        }
        $amount = $args[1];
        API::reduceMoney($player, intval($amount));
        $sender->sendMessage(Loader::getInstance()->getPrefix() . Loader::getInstance()->getMessage('sender.reduce.money', [
            'amount' => $amount,
            'name' => $player->getName()
        ]));
    }
}