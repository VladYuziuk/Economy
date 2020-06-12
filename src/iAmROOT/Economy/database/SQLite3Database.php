<?php
declare(strict_types=1);

namespace iAmROOT\Economy\database;


use iAmROOT\Economy\Statements;
use pocketmine\player\Player;

class SQLite3Database extends BaseDatabase{

    public function init(): void{
        $this->getConnector()->executeGeneric(Statements::ECONOMY_INIT_COMMAND);
    }

    public function addUser(Player $player): void{
        $username = strtolower($player->getName());
        $money = 0;
        $this->getConnector()->executeInsert(Statements::ECONOMY_ADD_PLAYER_COMMAND, [
            'username' => $username,
            'money' => $money
        ]);
    }

    public function getUserData(Player $player, callable $callable): void{
        $username = strtolower($player->getName());
        $data = [];
        $this->getConnector()->executeSelect(Statements::ECONOMY_GET_PLAYER_COMMAND, [
            'username' => $username
        ], $callable);
    }
}