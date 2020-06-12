<?php
declare(strict_types=1);

namespace iAmROOT\Economy;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;

class EventListener implements Listener{
    /** @var Loader */
    private $loader;

    /**
     * @return Loader
     */
    public function getLoader(): Loader{
        return $this->loader;
    }

    /**
     * EventListener constructor.
     * @param Loader $loader
     */
    public function __construct(Loader $loader){
        $this->loader = $loader;
    }

    /**
     * @param PlayerJoinEvent $event
     * @priority LOW
     */
    public function onJoin(PlayerJoinEvent $event): void{
        $player = $event->getPlayer();
        $this->getLoader()->getDatabase()->getUserData($player, function(array $rows) use ($player){
            if(empty($rows)){
                $this->getLoader()->getDatabase()->addUser($player);
            }
        });
    }
}