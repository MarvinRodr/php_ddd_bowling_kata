<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Tests\Shared\Domain\NumberMother;

final class LaunchSecondOneMother
{
    private const MAX_NUM_PINS_CAN_BE_BOWLED = 10;

    public static function create(?int $value = null): LaunchSecondOne
    {
        return new LaunchSecondOne($value ?? NumberMother::createRandomBetween(0, self::MAX_NUM_PINS_CAN_BE_BOWLED + 1));
    }
}
