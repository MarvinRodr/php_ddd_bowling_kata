<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain\Exceptions;

use App\Modules\Launches\Domain\LaunchNumFrame;

final class InvalidArgumentBonusLaunchException extends InvalidArgumentLaunchException
{
    public function __construct(
        private readonly LaunchNumFrame $numFrame,
        private readonly int $totalPinsKnocked
    ) {
        parent::__construct(
            sprintf(
                "Bonus launch not valid, number of frames <%d> or total pins knocked down <%d> is not valid",
                $this->numFrame->value(),
                $this->totalPinsKnocked
            )
        );
    }
}
