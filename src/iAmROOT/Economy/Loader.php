<?php
declare(strict_types=1);

namespace iAmROOT\Economy;

use iAmROOT\Economy\command\AddMoneyCommand;
use iAmROOT\Economy\command\MyMoneyCommand;
use iAmROOT\Economy\command\ReduceMoneyCommand;
use iAmROOT\Economy\database\BaseDatabase;
use iAmROOT\Economy\database\SQLite3Database;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use poggit\libasynql\libasynql;

class Loader extends PluginBase{
    /** @var Loader */
    private static $instance;
    /** @var string  */
    private $prefix = '';
    /** @var string[]  */
    private $messages = [];
    /** @var array  */
    private $settings = [];
    /** @var BaseDatabase */
    private $database;

    /**
     * @return array
     */
    public function getSettings(): array{
        return $this->settings;
    }

    /**
     * @return Loader
     */
    public static function getInstance(): Loader{
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getPrefix(): string{
        return $this->prefix;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array{
        return $this->messages;
    }

    /**
     * @return BaseDatabase
     */
    public function getDatabase(): BaseDatabase{
        return $this->database;
    }

    protected function onLoad(){
        self::$instance = $this;
    }

    protected function onEnable(){
        $this->saveResource('settings.yml');
        $this->saveResource('messages.yml');
        $this->saveDefaultConfig();
        $this->database = new SQLite3Database($this, libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql"
        ]));
        $this->getDatabase()->init();
        $this->settings = (new Config($this->getDataFolder() . 'settings.yml', Config::YAML))->getAll();
        $this->messages = (new Config($this->getDataFolder() . 'messages.yml', Config::YAML))->getAll();
        $this->prefix = str_replace('&', TextFormat::ESCAPE, $this->settings['prefix']);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        $this->getServer()->getCommandMap()->register('mymoney', new MyMoneyCommand('mymoney', 'returns amount of your money'));
        $this->getServer()->getCommandMap()->register('addmoney', new AddMoneyCommand('addmoney', 'add money to exact player'));
        $this->getServer()->getCommandMap()->register('reducemoney', new ReduceMoneyCommand('reducemoney', 'reduce money to exact player'));

        $this->getLogger()->info($this->getPrefix() . $this->getMessage('start.up.message'));
    }

    /**
     * @param string $id
     * @param array $args
     * @return string
     */
    public function getMessage(string $id, array $args = []): string{
        $message = $this->messages[$id];
        $message = str_replace('&', TextFormat::ESCAPE, $message);
        foreach($args as $arg => $value){
            $message = str_replace('{' . $arg . '}', $value, $message);
        }
        return $message;
    }
}