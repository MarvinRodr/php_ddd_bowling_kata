<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Calc;

use App\Modules\Launches\Domain\Launch;
use Illuminate\Support\Collection;

abstract class ScoreCalculator
{
    public function __construct(
        protected readonly Collection $launches,
        protected readonly Launch $currentLaunch,
        protected readonly int $index
    ) {
    }

    abstract public function calc(): int;

    protected function isLaunch(?Launch $launch): bool
    {
        return $launch instanceof Launch;
    }

    protected function isBonusLaunch(?Launch $launch): bool
    {
        return $this->isLaunch($launch) && $launch->isBonusLaunch();
    }
}
