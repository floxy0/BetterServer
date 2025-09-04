<?php
namespace floxy\BetterServer;
use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Main extends PluginBase{
 public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
  if(strtolower($command->getName())==="restart"){
   if($sender instanceof Player && !$sender->hasPermission("betterserver.restart")) return true;
   foreach(Server::getInstance()->getOnlinePlayers() as $player){
    $player->chat("/reconnect");
   }
   $this->getServer()->shutdown();
   return true;
  }
  return true;
 }
}
