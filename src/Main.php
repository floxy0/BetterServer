<?php
declare(strict_types=1);

namespace floxy\BetterServer;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\TransferPacket;

class Main extends PluginBase{

    public function onEnable(): void{
        $this->saveDefaultConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if(strtolower($command->getName()) !== "betterrestart") return false;
        if(!$sender->hasPermission("betterserver.restart")) return true;

        $config = $this->getConfig();
        $ip = $config->get("restart-ip", "127.0.0.1");
        $port = (int)$config->get("restart-port", 19132);

        foreach($this->getServer()->getOnlinePlayers() as $player){
            $pk = TransferPacket::create($ip, $port);
            $player->getNetworkSession()->sendDataPacket($pk);
        }

        $this->getServer()->shutdown();
        return true;
    }
}
