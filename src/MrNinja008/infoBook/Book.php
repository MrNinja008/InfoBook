<?php

namespace MrNinja008\infoBook;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\item\WrittenBook;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;

class Book extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event) {

        $player = $event->getPlayer();
        $config = new Config($this->getDataFolder().'player.yml', Config::YAML);

        if(!$config->exists($player->getName())){

            $config->set($player->getName());
            $config->save();

            $book = new WrittenBook();
            $book->setCustomName(TextFormat::colorize($this->getConfig()->get("BookName")));
            $book->setAuthor(TextFormat::colorize($this->getConfig()->get("AuthorName")));

            $contents = $this->getConfig()->get("BookContents");

            foreach ($contents as $index=>$content) $book->setPageText($index, $this->replaceTags($content, $player));

            $player->getInventory()->setItem((int)$this->getConfig()->get("BookInvSlot"), $book, true);
        }
    }

    public function replaceTags (string $string, Player $player) : string
    {
        return TextFormat::colorize(str_replace(["{max_players}", "{online_players}", "{player}","{ping}" ], [$this->getServer()->getQueryInformation()->getMaxPlayerCount(), (string) count($this->getServer()->getQueryInformation()->getPlayerCount()), $player->getName(), (string) $player->getPing()], $string));
    }
}
