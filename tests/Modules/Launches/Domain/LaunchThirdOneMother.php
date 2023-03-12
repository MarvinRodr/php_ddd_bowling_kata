<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Launches\Domain\LaunchThirdOne;
use App\Tests\Shared\Domain\NumberMother;

final class LaunchThirdOneMother
{
    private const MAX_NUM_PINS_CAN_BE_BOWLED = 10;

    public static function create(?int $value = null): LaunchThirdOne
    {
        return new LaunchThirdOne($value ?? NumberMother::createRandomBetween(0, self::MAX_NUM_PINS_CAN_BE_BOWLED + 1));
    }
}
