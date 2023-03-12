<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\Launch;
use App\Tests\Modules\Players\Domain\PlayerMother;

final class LaunchSpareMother
{
    public static function create(): Launch
    {
        return new Launch(
            LaunchIdMother::create(),
            PlayerMother::create(),
            LaunchFirstOneMother::create(9),
            LaunchSecondOneMother::create(1),
            LaunchThirdOneMother::create(0),
            LaunchNumFrameMother::create(1),
        );
    }
}
