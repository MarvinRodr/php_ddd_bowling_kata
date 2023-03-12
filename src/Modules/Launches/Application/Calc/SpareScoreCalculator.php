<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Calc;

final class SpareScoreCalculator extends ScoreCalculator
{
    public function calc(): int
    {
        // Get the next launch
        $nextLaunch = $this->launches->get($this->index + 1);

        // If it isn`t outside the range of the array of Launches
        if ($this->isLaunch($nextLaunch)) {
            return $this->currentLaunch->totalPinsKnocked() + $nextLaunch->firstOne()->value();
        }

        return $this->currentLaunch->totalPinsKnocked();
    }
}
