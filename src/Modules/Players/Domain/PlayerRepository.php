<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain;

interface PlayerRepository
{
    public function save(Player $player): void;
}
