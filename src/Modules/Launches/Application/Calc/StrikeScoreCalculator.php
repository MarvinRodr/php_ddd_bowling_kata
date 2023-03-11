<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Calc;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\Launches;

final class StrikeScoreCalculator
{
    public function __construct(
        private readonly Launches $launches,
        private readonly Launch $currentLaunch,
        private readonly int $index
    ) {
    }

    /**
     * @throws \Exception
     */
    public function calc(): int
    {
        $score = $this->currentLaunch->totalPinsKnocked();

        // Get the next launch
        $nextLaunch = $this->launches->getCollection()->get($this->index + 1);

        // Get the next + 1 launch
        $nextOfNextLaunch = $this->launches->getCollection()->get($this->index + 2);

        // If it isn`t outside the range of the array of Launches
        if ($nextLaunch instanceof Launch) {
            $score += $nextLaunch->totalPinsKnocked();
        }

        if ($nextOfNextLaunch instanceof Launch) {
            $score += $nextOfNextLaunch->totalPinsKnocked();
        }

        return $score;
    }
}
