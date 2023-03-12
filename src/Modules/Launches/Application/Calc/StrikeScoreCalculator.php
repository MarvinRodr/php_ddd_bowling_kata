<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Calc;

use App\Modules\Launches\Domain\Launch;
use Exception;

final class StrikeScoreCalculator extends ScoreCalculator
{
    /**
     * @throws Exception
     */
    public function calc(): int
    {
        $score = $this->currentLaunch->totalPinsKnocked();

        // Get the next launch
        $nextLaunch = $this->launches->get($this->index + 1);

        // Get the next + 1 launch
        $nextOfNextLaunch = $this->launches->get($this->index + 2);

        // If it isn`t outside the range of the array of Launches
        $score += $this->getStrikePoints($nextLaunch, $nextOfNextLaunch);

        return $score;
    }

    private function getStrikePoints(?Launch $nextLaunch, ?Launch $nextOfNextLaunch): int
    {
        $points = 0;

        if ($this->isLaunch($nextLaunch)) {
            if ($this->isBonusLaunch($nextLaunch)) {
                $points += ($nextLaunch->totalPinsKnocked() - $nextLaunch->thirdOne()->value());
            } elseif ($nextLaunch->isStrike()) {
                $points += $nextLaunch->totalPinsKnocked() + ($this->isLaunch($nextOfNextLaunch) ? $nextOfNextLaunch->firstOne()->value() : 0);
            } else {
                $points += $nextLaunch->totalPinsKnocked();
            }
        }

        return $points;
    }
}
