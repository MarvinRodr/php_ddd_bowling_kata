<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Modules\Players\Domain\Player;
use App\Tests\Modules\Players\Domain\PlayerMother;

final class LaunchPlayerMother
{
    public static function create(): Player
    {
        return new PlayerMother::create();
    }
}