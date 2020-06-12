<?php
declare(strict_types=1);

namespace iAmROOT\Economy\command;


use iAmROOT\Economy\API;
use iAmROOT\Economy\Loader;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class MyMoneyCommand extends Command{

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player){
            API::getUserMoney($sender, function(Player $player, int $money){
                $player->sendMessage(Loader::getInstance()->getPrefix() . Loader::getInstance()->getMessage('my.money', [
                    'amount' => $money
                ]));
            });
        }
    }
}