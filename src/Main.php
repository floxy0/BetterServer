<?php
namespace floxy\BetterServer;
use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\network\mcpe\protocol\TransferPacket;

class Main extends PluginBase{
 public function onEnable(): void{
  $this->saveDefaultConfig();
 }
 public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
  if(strtolower($command->getName())==="restart"){
   if($sender instanceof Player && !$sender->hasPermission("betterserver.restart")) return true;
   $ip = $this->getConfig()->get("restart-ip","0.0.0.0");
   $port = (int)$this->getConfig()->get("restart-port",19132);
   foreach(Server::getInstance()->getOnlinePlayers() as $player){
    $player->getNetworkSession()->sendDataPacket(TransferPacket::create($ip,$port));
   }
   $this->getServer()->shutdown();
   return true;
  }
  return true;
 }
}
