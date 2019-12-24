<?php

namespace SimpleAlias;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\{Utils, Config, TextFormat};
use pocketmine\command\{Command, CommandSender, CommandExecuter, CommandMap, ConsoleCommandSender};
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
	
	class Main extends PluginBase implements Listener{
	
		public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->saveDefaultConfig();
			if(is_dir($this->getDataFolder() . "alias/") == false){
				@mkdir($this->getDataFolder() . "alias/", 0777, true);
				}
			$this->getLogger()->info("Version: 1.0.1 for API: 3.0.0");
		}
		
		public function onJoin(PlayerJoinEvent $e){
			$p = $e->getPlayer();
			$name = $p->getName();
			$ip = $p->getAddress();
			$uid = $p->getUniqueId();
			$cid = $p->getClientId();
			$xid = $p->getXuid();
			$track = $this->getConfig()->get("track");
			if(strtolower($track) === "ip"){
				if(file_exists($this->getDataFolder() . "alias/" . $ip)){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $ip, true));
					if(!in_array($name, $file)){
						file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n", FILE_APPEND);
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "This account is a possible alt!");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $ip, $name . ",\n");
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "No records found for this person.");
					}
				}
			if(strtolower($track) === "uid"){
				if(file_exists($this->getDataFolder() . "alias/" . $uid)){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $uid, true));
					if(!in_array($name, $file)){
							file_put_contents($this->getDataFolder() . "alias/" . $uid, $name . ",\n", FILE_APPEND);
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "This account is a possible alt!");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $uid, $name . ",\n");
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "No records found for this person.");
					}
				}
			if(strtolower($track) === "cid"){
				if(file_exists($this->getDataFolder() . "alias/" . $cid)){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $cid, true));
					if(!in_array($name, $file)){
							file_put_contents($this->getDataFolder() . "alias/" . $cid, $name . ",\n", FILE_APPEND);
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "This account is a possible alt!");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $cid, $name . ",\n");
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "No records found for this person.");
					}
				}
			if(strtolower($track) === "xid"){
				if(file_exists($this->getDataFolder() . "alias/" . $xid)){
					$file = explode(",\n", file_get_contents($this->getDataFolder() . "alias/" . $xid, true));
					if(!in_array($name, $file)){
							file_put_contents($this->getDataFolder() . "alias/" . $xid, $name . ",\n", FILE_APPEND);
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "This account is a possible alt!");
					}
					} else {
						file_put_contents($this->getDataFolder() . "alias/" . $xid, $name . ",\n");
						$this->getLogger()->info(TextFormat::GOLD . "(!)" . TextFormat::RED . "No records found for this person.");
					}
				}
		}
		
		public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
			switch(strtolower($command->getName())){
				case "alias":
				if(isset($args[0])){
					$p = $this->getServer()->getPlayer($args[0]);
					if($p != null && $p->isOnline() && $p instanceof Player){
						$ip = $p->getAddress();
						$uid = $p->getUniqueId();
						$cid = $p->getClientId();
						$xid = $p->getXuid();
						$track = $this->getConfig()->get("track");
						if(strtolower($track) === "ip"){
							$contents = file_get_contents($this->getDataFolder() . "alias/" . $ip, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage("TextFormat::GOLD . "(!)" . TextFormat::GREEN . "Current accounts found under players IP:" . TextFormat::RED . $final_list);
							}
						if(strtolower($track) === "uid"){
							$contents = file_get_contents($this->getDataFolder() . "alias/" . $uid, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage(TextFormat::GOLD . "(!)" . TextFormat::GREEN . "Current accounts found under players UID:" . TextFormat::RED . $final_list);
							}
						if(strtolower($track) === "cid"){
							$contents = file_get_contents($this->getDataFolder() . "alias/" . $cid, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage(TextFormat::GOLD . "(!)" . TextFormat::GREEN . "Current accounts found under players CID:" . TextFormat::RED . $final_list);
							}
						if(strtolower($track) === "xid"){
							$contents = file_get_contents($this->getDataFolder() . "alias/" . $xid, true);
							$final_list = implode(", ", array_unique(explode(",\n", $contents)));
							$sender->sendMessage(TextFormat::GOLD . "(!)" . TextFormat::GREEN . "Current accounts found under players XID:" . TextFormat::RED . $final_list);
							}
							return true;
						} else {
						$sender->sendMessage(TextFormat::GOLD . "(!)" . TextFormat::GRAY . "Error, it seems to be that the current player is not online!");
						return false;
						}
					} else {
					$sender->sendMessage(TextFormat::GOLD . "(!)" . TextFormat::GRAY . "Usage: /alias <player>");
					return false;
					}
				break;
			}
		}
		
	}
