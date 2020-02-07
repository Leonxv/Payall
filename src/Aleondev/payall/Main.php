<?php

namespace Aleondev\payall;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;


class Main extends PluginBase{

	public function onEnable() : void {
		$this->getLogger()->info("§4Pay§eAll §aon");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		if($command->getName() == "payall") {
			if($sender->hasPermission("payall.command")) {
				if(isset($args[0])) {
					if(is_numeric($args[0])) {
						$name = $sender->getName();
						$setmoney = $args[0];
						$money = EconomyAPI::getInstance()->myMoney($sender->getName());
							if($money >= $setmoney) {
								foreach ($this->getServer()->getOnlinePlayers() as $player) {
								$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->addMoney($player, $args[0]);
								$spieler = $player->getName();
								$player->sendMessage("§f[§4Pay§eAll§f] §r»§b Du hast durch den §4Pay§eAll§b von §r§6".$name." §e" .$args[0]. "$ §berhalten!");
                                                                $player->addTip("§f[§4Pay§eAll§f] §r»§b Hat Aleondev Gecodet!");
								}
								$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->reduceMoney($sender, $setmoney);
								$sender->sendMessage("§f[§4Pay§eAll§f] §r» §4Du hast §e".$setmoney."$ §4an die alle spieler gegeben!");
							} else {
								$sender->sendMessage("§f[§4Pay§eAll§f] §r» §cDu hast zu wenig Geld!");
							}
					} else {
						$sender->sendMessage("§f[§4Pay§eAll§f] §r» §cGib eine Zahl an!");
					}
				} else {
					$sender->sendMessage("§f[§4Pay§eAll§f] §r» §6Benutze:§b /payall [Betrag]");
				}
			} else {
				$sender->sendMessage("§f[§4Pay§eAll§f] §r» §cDu hast keine Berechtigungen diesen Befehl zu nutzen!");
			}
		}
	return true;
	}
}
