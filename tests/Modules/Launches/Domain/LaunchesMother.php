<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\Launches;
use App\Tests\Shared\Domain\Repeater;

final class LaunchesMother
{
    public static function create(
        int $howMany,
        ?array $launches = null,
    ): Launches {
        return new Launches(
            $launches ?? Repeater::repeat(fn () => LaunchMother::create(), $howMany),
        );
    }
}
