<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Tests\Shared\Domain\NumberMother;

final class LaunchNumFrameMother
{
    private const MAX_NUM_OF_FRAMES = 10;

    public static function create(?int $value = null): LaunchNumFrame
    {
        return new LaunchNumFrame($value ?? NumberMother::createRandomBetween(0,self::MAX_NUM_OF_FRAMES + 1));
    }
}