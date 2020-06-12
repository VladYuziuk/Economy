<?php
declare(strict_types=1);

namespace iAmROOT\Economy;

use pocketmine\player\Player;

class API{
    public static function getUserMoney(Player $player, callable $function): void{
        Loader::getInstance()->getDatabase()->getUserData($player, function($rows) use ($player, $function){
            if(!empty($rows)){
                $row = $rows[0];
                $function($player, $row['money']);
            }
        });
    }

    public static function addMoney(Player $player, int $amount): void{
        self::getUserMoney($player, function(Player $player, int $money) use ($amount){
            $username = strtolower($player->getName());
            Loader::getInstance()->getDatabase()->getConnector()->executeGeneric(Statements::ECONOMY_UPDATE_PLAYER_MONEY, [
                'username' => $username,
                'amount' => $money + $amount
            ]);
        });
    }

    public static function reduceMoney(Player $player, int $amount): void{
        self::getUserMoney($player, function(Player $player, int $money) use ($amount){
            $username = strtolower($player->getName());
            Loader::getInstance()->getDatabase()->getConnector()->executeGeneric(Statements::ECONOMY_UPDATE_PLAYER_MONEY, [
                'username' => $username,
                'amount' => $money - $amount
            ]);
        });
    }
}