<?php 

namespace MrNinja008\InfoBook;

use pocketmine\item\Item;
use pocketmine\item\WrittenBook;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class Book extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
  }
  
  public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        if($player->getFirstPlayed() == $player->getLastPlayed()) {
        $book = Item::get(Item::WRITTEN_BOOK);
        if(!$book instanceof WrittenBook) return;
        $book->setCustomName("§r".$this->getConfig()->get("BookName"));
        $book->setPageText(0,$this->getConfig()->get("PageText"));
        $book->setAuthor($this->getConfig()->get("AuthorName"));
        $player->getInventory()->setItem($this->getConfig()->get("BookInvSlot"), $book, true);
       }
    }
 }
