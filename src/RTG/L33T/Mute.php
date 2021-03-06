<?php

namespace RTG\L33T;

// Essentials
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
// ---

// Commands
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
// ---

// Event
use pocketmine\event\player\PlayerChatEvent;
// ---

class Mute extends PluginBase implements Listener {
	
	public function onLoad() {
		$this->getLogger()->warning("
		* Checking ...
		");
	}
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->enabled = array();
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $param) {
		switch(strtolower($cmd->getName())) {
			
			case "mute":
				if($sender->isOp() or $sender->hasPermission("mute.command")) {
					
					if(isset($param[0])) {
						
						$p = $param[0];
						
							if($this->getServer()->getPlayer($p) === null) {
								$sender->sendMessage("$p is not a Valid Player!");
							}
							else {
								
								$pl = $this->getServer()->getPlayer($p);
								
								if(!(isset($this->enabled[strtolower($p)]))) {
									$this->enabled[strtolower($p)] = strtolower($p);
									$sender->sendMessage("You have Muted $p");
									$pl->sendMessage(TF::GREEN . "You have been Muted!");
								}
								else {
									$sender->sendMessage("$p isnt Muted!");
								}
									
							}
								
					}
					else {
						$sender->sendMessage("Usage: /mute {player}");
					}
						
				}
				else {
					$sender->sendMessage(TF::RED . "You have no permission to use this command!");
				}
				return true;
			break;
			
			case "unmute":
				if($sender->isOp() or $sender->hasPermission("mute.command")) {
					
					if(isset($param[0])) {
						
						$p = $param[0];
							
							if($this->getServer()->getPlayer($p) === null) {
								$sender->sendMessage("$p is not a Valid Player!");
							}
							else {
								
								$pl = $this->getServer()->getPlayer($p);
								
								if(isset($this->enabled[strtolower($p)])) {
									unset($this->enabled[strtolower($p)]);
									$sender->sendMessage("You have Unmuted $p");
									$pl->sendMessage(TF::GREEN . "You have been Unmuted!");
								}
								
							}
					
					}
					else {
						$sender->sendMessage("Usage: /unmute {player}");
					}
						
				}
				else {
					$sender->sendMessage(TF::RED . "You have no permission to use this command!");
				}
				return true;
			break;
		
		}
	}
		
	public function onChat(PlayerChatEvent $e) {
		$p = $e->getPlayer();
		$n = $p->getName();
		
			if(isset($this->enabled[strtolower($n)])) {
				$p->sendMessage(TF::RED . "You cant chat! You have been muted!");
				$e->setCancelled();
			}
	
	}
	
	public function onDisable() {
	}

}