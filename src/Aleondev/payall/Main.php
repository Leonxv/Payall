<?php

namespace Aleondev\payall;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;


class Main extends PluginBase{
	
	public const PREFIX = " §a[Payall] §6";

	public function onEnable() : void {
		$this->getLogger()->info("§4Pay§eAll §aon");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
	switch($command){
	case "payall":
    			if(isset($args[0])){
    				if (is_numeric($args[0])) {
    					$amount = $args[0];
    					$anz = count($this->getServer()->getOnlinePlayers());
    					$tanz = $anz - 1;
    					$maxpay = $amount * $tanz;
    					$mymoney = EconomyAPI::getInstance()->myMoney($sender);
    					if($maxpay <= $mymoney) {
							foreach ($this->getServer()->getOnlinePlayers() as $player) {
								$name = $player->getName();
								$iname = strtolower($name);
								EconomyAPI::getInstance()->addMoney($iname, $amount);	
								EconomyAPI::getInstance()->reduceMoney($sender, $amount);
			
							}
							$this->getServer()->broadcastMessage(self::PREFIX . $sender->getName() . "§f hat §e" . $maxpay . " $ verteilt. Jeder hat: §e". $amount . "§f erhalten.");
						}
						else {$sender->sendMessage(self::PREFIX ."Du hast zu wenig Geld!");}
					}
					else {$sender->sendMessage(self::PREFIX ."Deine Eingabe ist keine Zahl!");}

				}
				else {$sender->sendMessage(self::PREFIX ."Keine Summe angegeben!");}
			}
            else {$sender->sendMessage(self::PREFIX ."Keine Berechtigung!");
            } 
	} 
} 
