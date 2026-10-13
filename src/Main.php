<?php

namespace ReinfyTeam\SlapperRotation;

use ReinfyTeam\SlapperRotation\SlapperListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

	public function onLoad() :void{
        $this->saveResource("config.yml");
        $this->reloadConfig();
        $this->checkConfig();
    }
    
    private function checkConfig() : void{
        $log = $this->getLogger();
        $pluginConfigResource = $this->getResource("config.yml");
        if($pluginConfigResource === null) {
            $log->critical("Missing default configuration.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        $contents = stream_get_contents($pluginConfigResource);
        fclose($pluginConfigResource);
        if($contents === false) {
            $log->critical("Unable to read default configuration.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        $pluginConfig = yaml_parse($contents);
        if(!is_array($pluginConfig) || !array_key_exists("config-version", $pluginConfig)) {
            $log->critical("Invalid configuration.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $config = $this->getConfig();
        if($config->get("config-version") === $pluginConfig["config-version"]) return;
        $log->notice("Your config is outdated!");
        $log->info("Your old config.yml is renamed as old-config.yml");
        $dataFolder = rtrim($this->getDataFolder(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if(!rename($dataFolder . "config.yml", $dataFolder . "old-config.yml")) {
            $log->error("Unable to preserve the old config.yml before migration.");
            return;
        }
        $this->saveResource("config.yml", true);
    }

	public function onEnable() :void {
        $this->loadListener();
        $config = $this->getConfig();
        $log = $this->getLogger();
        $maxDistanceValue = $config->get("max-distance");
        if (!is_numeric($maxDistanceValue)){
            $log->info("Max Distance cant be blank!");
            $config->set("max-distance", 8);
            $config->save();
            return;
        }
        if ((float) $maxDistanceValue < 4){
            $log->info(TextFormat::RED."Your max distance is too low. Make sure your max-distance in config is not at least higher on 4!");
            $log->info("[INFO] Max-Distance was changed to 8 as default.");
            $config->set("max-distance", 8);
            $config->save();
            return;
        }
		$this->saveDefaultConfig();
	}
        

        private function loadListener() : void {
            $this->getServer()->getPluginManager()->registerEvents(new SlapperListener($this), $this);
        }
}
