<?php

namespace slapper\entities;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;

class SlapperEntity extends Entity {
    public bool $onGround;

    public function getId(): int {}

    public function getLocation(): mixed {}
}

class SlapperHuman extends Human {
    public function getEyeHeight(): float {}
}
