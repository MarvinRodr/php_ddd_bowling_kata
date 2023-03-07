<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain;

use Ramsey\Uuid\UuidInterface;

interface PlayerRepository
{
    public function save(Player $player): void;

    public function findById(UuidInterface $id): ?Player;
}
