<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application;

use App\Modules\Launches\Domain\Launch;
use App\Shared\Domain\Response;

final class LaunchResponse implements Response
{
    public function __construct(private readonly Launch $launch)
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->launch->id(),
            'player_name' => $this->launch->player()->id(),
            'first_one' => $this->launch->firstOne()->value(),
            'second_one' => $this->launch->secondOne()->value(),
            'third_one' => $this->launch->thirdOne()->value(),
            'num_frame' => $this->launch->numFrame()->value(),
            'is_strike' => $this->launch->isStrike(),
            'is_spare' => $this->launch->isSpare(),
            'is_bonus' => $this->launch->isBonusLaunch(),
        ];
    }
}
