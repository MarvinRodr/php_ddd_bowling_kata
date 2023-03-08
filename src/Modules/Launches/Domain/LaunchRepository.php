<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain;

use Ramsey\Uuid\UuidInterface;

interface LaunchRepository
{
    public function save(Launch $launch): void;

    public function findByPlayerId(UuidInterface $player_id): Launches;
}
