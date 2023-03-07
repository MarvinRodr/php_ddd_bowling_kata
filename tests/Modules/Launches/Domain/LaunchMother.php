<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Players\Domain\Player;
use App\Tests\Modules\Players\Domain\PlayerMother;
use Ramsey\Uuid\UuidInterface;

final class LaunchMother
{
    public static function create(
        ?UuidInterface $id = null,
        ?Player $player = null,
        ?LaunchFirstOne $first_one = null,
        ?LaunchSecondOne $second_one = null,
        ?LaunchNumFrame $num_frame = null
    ): Launch {
        return new Launch(
            $id ?? LaunchIdMother::create(),
            $player ?? PlayerMother::create(),
            $first_one ?? LaunchFirstOneMother::create(),
            $second_one ?? LaunchSecondOneMother::create(),
            $num_frame ?? LaunchNumFrameMother::create(),
        );
    }
}
