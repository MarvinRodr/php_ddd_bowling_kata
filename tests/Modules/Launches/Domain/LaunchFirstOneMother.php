<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Tests\Shared\Domain\NumberMother;

final class LaunchFirstOneMother
{
    private const MAX_NUM_PINS_CAN_BE_BOWLED = 10;

    public static function create(?int $value = null): LaunchFirstOne
    {
        return new LaunchFirstOne($value ?? NumberMother::createRandomBetween(0, self::MAX_NUM_PINS_CAN_BE_BOWLED + 1));
    }
}
