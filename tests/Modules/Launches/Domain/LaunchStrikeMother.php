<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\Launch;
use App\Tests\Modules\Players\Domain\PlayerMother;

final class LaunchStrikeMother
{
    public static function create(
        ?int $num_frame = null
    ): Launch {
        return new Launch(
            LaunchIdMother::create(),
            PlayerMother::create(),
            LaunchFirstOneMother::create(10),
            LaunchSecondOneMother::create(0),
            LaunchThirdOneMother::create(0),
            LaunchNumFrameMother::create($num_frame),
        );
    }
}
