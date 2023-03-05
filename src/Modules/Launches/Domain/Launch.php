<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain;

use App\Modules\Players\Domain\Player;
use App\Shared\Domain\Aggregate\AggregateRoot;

class Launch extends AggregateRoot
{
    public function __construct(
        private readonly LaunchId $id,
        private readonly Player $player,
        private readonly int $first_one,
        private readonly int $second_one
    ) {
    }

    public static function create(
        LaunchId $id,
        Player $player,
        int $first_one,
        int $second_one
    ): self
    {
        return new self($id, $player, $first_one, $second_one);
    }

    public function id(): LaunchId
    {
        return $this->id;
    }

    public function player(): Player
    {
        return $this->player;
    }

    public function firstOne(): int
    {
        return $this->first_one;
    }

    public function secondOne(): int
    {
        return $this->second_one;
    }
}