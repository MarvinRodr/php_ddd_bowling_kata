<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Calc;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\Launches;

final class SpareScoreCalculator
{
    public function __construct(
        private readonly Launches $launches,
        private readonly Launch $currentLaunch,
        private readonly int $index
    ) {
    }

    public function calc(): int
    {
        // Get the next launch
        $nextLaunch = $this->launches->getCollection()->get($this->index + 1);

        // If it isn`t outside the range of the array of Launches
        if ($nextLaunch instanceof Launch) {
            return $this->currentLaunch->totalPinsKnocked() + $nextLaunch->totalPinsKnocked();
        }

        return $this->currentLaunch->totalPinsKnocked();
    }
}
