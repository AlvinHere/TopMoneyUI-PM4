<?php

namespace IrwanS\Topmoney;

/*

 *

 * name : TopMoneyUI

 * version : 1.0.4

 * info : don't change the author

 *

 */

use pocketmine\plugin\PluginBase;

use pocketmine\player\Player; 

use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\utils\Config;

use Jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener {

	public $i;

    /**

     * @deprecated

     *

     * @param callable|null $function

     * @return SimpleForm

     */

    public function createSimpleForm(callable $function = null) : SimpleForm {

        return new SimpleForm($function);

    }

	public function onLoad(): void{

		$this->saveResource("setting.yml");  

  }

	public function onEnable(): void{

		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->getServer()->getLogger()->info("TopMoneyUI Enabled!");

		@mkdir($this->getDataFolder());

    $this->saveDefaultConfig();

		$this->config = new Config($this->getDataFolder() . "setting.yml", Config::YAML);

	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $params) : bool{

		switch($command->getName()){

            case "topmoney":

                if($sender instanceof Player){

                    $this->TopMoney($sender);

                    return true;

                }else{

                    $sender->sendMessage("In-Game Only!");

                }

            break;

        }

        return true;

    }

	public function TopMoney($player){

		$money = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

		$top_money = $money->getAllMoney();

		$message = "";

		$message1 = "";

		$topmoney = "     §eTopMoney server    ";

		$topmoney1 = "     §6TopMoney server    ";

		if(count($top_money) > 0){

			arsort($top_money);

			$i = 1;

			foreach($top_money as $name => $money){

				$message .= "  §6» §f".$i."§l§a. §r§f".$name."§a§l: §r§f".$money." §a".$this->config->get("unit")."\n";

				$message1 .= " §6 ".$i.". §8".$name." §f".$money." §a".$this->config->get("unit")."\n";

				if($i >= 10){

					break;

					}

					++$i;

				}}

		$form = $this->createSimpleForm(function (Player $player, int $data = null){

			$result = $data;

			if($result === null){

				return true;

				}

				switch($result){

					case "0";

					break;

				}

			});

			$form->setTitle("§8»§6 TopMoneyUI §8«§r");

			$form->setContent("".$message);

			$form->addButton("§l§cEXIT\n§r§8Tap to exit", 0, "textures/blocks/barrier");

			$form->sendToPlayer($player);

			return $form;

	}

}
