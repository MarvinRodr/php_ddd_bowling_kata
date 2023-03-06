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
        private readonly LaunchFirstOne $first_one,
        private readonly LaunchSecondOne $second_one,
        private readonly LaunchNumFrame $num_frame
    ) {
    }

    public static function create(
        LaunchId $id,
        Player $player,
        LaunchFirstOne $first_one,
        LaunchSecondOne $second_one,
        LaunchNumFrame $num_frame
    ): self
    {
        return new self($id, $player, $first_one, $second_one, $num_frame);
    }

    public function id(): LaunchId
    {
        return $this->id;
    }

    public function player(): Player
    {
        return $this->player;
    }

    public function firstOne(): LaunchFirstOne
    {
        return $this->first_one;
    }

    public function secondOne(): LaunchSecondOne
    {
        return $this->second_one;
    }

    public function numFrame(): LaunchNumFrame
    {
        return $this->num_frame;
    }
}