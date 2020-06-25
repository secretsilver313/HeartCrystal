<?php

namespace CustomItems;

use pocketmine\Server;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\inventory\Inventory;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\Command;

class Main extends PluginBase {
   
   private $cooldown;

   public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
   {
          if($cmd->getName() == "hc") {
             if($sender instanceof Player) {
                if($sender->hasPermission("secret.hc.use")) {
                $inv = $sender->getInventory();
                $item = Item::get(399, 0, 1);
                $item->setCustomName("Heart Crystal");
                $item->setLore(["Gain an extra heart!\nLose extra Hearts on death!\n25% chance to LOSE a heart"]);
                $sender->$inv->addItem($item);
                $sender->sendMessage("You have recieved an Extra Heart Crystal");
                }
             else{
               $sender->sendMessage("No permission for this command.");
             }
             }
          }
   return true;
   }

   public function onPlayerInteractEvent(PlayerInteractEvent $event)
   {
      $player = $event->getPlayer();
      $inv = $player->getInventory();
      $item = Item::get(399, 0, 1);
	   if(!isset($this->cooldown[$player->getName()])){
         $this->cooldown[$player->getName()] = time() + 600; //[600 second] [0 hours] [10 minute] cool down 
         if($player->getItemInHand()->getId() == 399) {
            if($player->getMaxHealth() < 40) {
               $player->setMaxHealth->getMaxHealth() + 1;
               if($inv->contains(Item::get(399, 0, 1))) {
                  $inv->removeItem(Item::get(399, 0, 1));
                  }elseif($player->getMaxHealth() == 40) {
                          $player->sendMessage("MAX HEARTS REACHED");
      //cooldown
	                       if(time() < $this->cooldown[$player->getName()]){
	                          $minutes = ($this->cooldown[$player->getName()] - time()) / 60;
                             $player->sendMessage("§7(§c!§7) §cCooldown §5" . (round($minutes)) . " §cminutes remaining");
                          }
               }
            }
         }
      }
   }
}
