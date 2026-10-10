<?php

namespace slapper\entities;

class SlapperEntity {
    public bool $onGround;

    public function getId(): int {}

    public function getLocation(): mixed {}
}

class SlapperHuman extends SlapperEntity {
    public function getEyeHeight(): float {}
}
