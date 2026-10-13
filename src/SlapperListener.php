<?php

namespace ReinfyTeam\SlapperRotation;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
use pocketmine\player\Player;
use slapper\entities\SlapperEntity;
use slapper\entities\SlapperHuman;
use ReinfyTeam\SlapperRotation\Main;

class SlapperListener implements Listener {
    public function __construct(private Main $plugin){
        //NOOP
    }

    private function getActorRuntimeId(SlapperEntity|SlapperHuman $entity) : int {
        return $entity->getId();
    }

    private function getEyeHeight(SlapperHuman $entity) : float {
        return $entity->getEyeHeight();
    }

    private function isOnGround(SlapperHuman $entity) : bool {
        return $entity->onGround;
    }

    public function onMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $maxDistanceValue = $this->plugin->getConfig()->get("max-distance");
        $maxDistance = is_numeric($maxDistanceValue) ? (float) $maxDistanceValue : 0.0;

            if ($event->getFrom()->distance($event->getTo()) < 0.1) {
                return;
            }
            foreach ($player->getWorld()->getNearbyEntities($player->getBoundingBox()->expandedCopy($maxDistance, $maxDistance, $maxDistance), $player) as $entity) {
                if (($entity instanceof SlapperHuman) or $entity instanceof SlapperEntity) {
                    /** @var object{x: float, y: float, z: float} $entityLocation */
                    $entityLocation = $entity->getLocation();
                    $angle = atan2($player->getLocation()->z - $entityLocation->z, $player->getLocation()->x - $entityLocation->x);
                    $yaw = (($angle * 180) / M_PI) - 90;
                    $angle = atan2((new Vector2($entityLocation->x, $entityLocation->z))->distance(new Vector2($player->getLocation()->x, $player->getLocation()->z)), $player->getLocation()->y - $entityLocation->y);
                    $pitch = (($angle * 180) / M_PI) - 90;
                    if ($entity instanceof SlapperHuman) {
                        $actorRuntimeId = $this->getActorRuntimeId($entity);
                        $eyeHeight = $this->getEyeHeight($entity);
                        $onGround = $this->isOnGround($entity);
                        $pk = new MovePlayerPacket();
                        $pk->actorRuntimeId = $actorRuntimeId;
                        $pk->position = new Vector3($entityLocation->x, $entityLocation->y + $eyeHeight, $entityLocation->z);
                        $pk->yaw = $yaw;
                        $pk->pitch = $pitch;
                        $pk->headYaw = $yaw;
                        $pk->onGround = $onGround;
                        $pk->telemetryData = null;
                        $player->getNetworkSession()->sendDataPacket($pk);
                    } elseif ($entity instanceof SlapperEntity) {
                        $actorRuntimeId = $this->getActorRuntimeId($entity);
                        $pk = new MoveActorAbsolutePacket();
                        $pk->actorRuntimeId = $actorRuntimeId;
                        $pk->position = new Vector3($entityLocation->x, $entityLocation->y, $entityLocation->z);
                        $pk->pitch = $pitch;
                        $pk->yaw = $yaw;
                        $pk->headYaw = $yaw;
                        $player->getNetworkSession()->sendDataPacket($pk);
                }
            }
        }
    }

}
