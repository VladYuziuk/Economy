<?php
declare(strict_types=1);

namespace iAmROOT\Economy\database;


use iAmROOT\Economy\Loader;
use pocketmine\player\Player;
use poggit\libasynql\DataConnector;

abstract class BaseDatabase{
    /** @var DataConnector */
    private $connector;
    /** @var Loader */
    private $loader;

    /**
     * @return Loader
     */
    public function getLoader(): Loader{
        return $this->loader;
    }

    /**
     * @return DataConnector
     */
    public function getConnector(): DataConnector{
        return $this->connector;
    }

    /**
     * BaseDatabase constructor.
     * @param Loader $loader
     * @param DataConnector $connector
     */
    public function __construct(Loader $loader, DataConnector $connector){
        $this->loader = $loader;
        $this->connector = $connector;
    }

    abstract public function init(): void;

    abstract public function addUser(Player $player): void;

    abstract public function getUserData(Player $player, callable $callable): void;
}