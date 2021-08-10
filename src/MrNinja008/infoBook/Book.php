<?php 

namespace MrNinja008\infoBook;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\item\WrittenBook;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

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
            $book = Item::get(Item::WRITTEN_BOOK);
            if(!$book instanceof WrittenBook) return;
            $book->setCustomName("§r".$this->getConfig()->get("BookName"));
            $book->setPageText(0,$this->getConfig()->get("Page1 Text"));
            $book->setPageText(1,$this->getConfig()->get("Page2 Text"));
            $book->setPageText(2,$this->getConfig()->get("Page3 Text"));
            $book->setPageText(3,$this->getConfig()->get("Page4 Text"));
            $book->setPageText(4,$this->getConfig()->get("Page5 Text"));

            $book->setAuthor($this->getConfig()->get("AuthorName"));
            $player->getInventory()->setItem($this->getConfig()->get("BookInvSlot"), $book, true);
    }
   }
}
