<?php

namespace MrNinja008\infoBook;

use pocketmine\utils\Config;
use pocketmine\item\WrittenBook;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;

class Book extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->saveResource("player.yml");
        $this->player = new Config($this->getDataFolder() . "player.yml", Config::YAML);
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $config = new Config($this->getDataFolder().'player.yml', Config::YAML);
        if(!$config->exists($player->getName())){
            $config->set($player->getName());
            $config->save();
            $book = new WrittenBook();
            $book->setCustomName(TextFormat::WHITE.$this->getConfig()->get("BookName"));
            $contents = $this->getConfig()->get("BookContents");
            for ($page = 0; $page < count($contents); $page++) {
                $book->setPageText($page, $contents[$page]);
            }

            $book->setAuthor($this->getConfig()->get("AuthorName"));
            $player->getInventory()->setItem($this->getConfig()->get("BookInvSlot"), $book, true);
        }
    }
}
