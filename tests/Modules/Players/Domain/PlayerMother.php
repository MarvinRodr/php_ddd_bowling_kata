<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Domain;

use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\ValueObjects\PlayerId;
use App\Modules\Players\Domain\ValueObjects\PlayerName;

final class PlayerMother
{
    public static function create(
        ?PlayerId $id = null,
        ?PlayerName $name = null
    ): Player {
        return new Player(
            $id ?? PlayerIdMother::create(),
            $name ?? PlayerNameMother::create()
        );
    }
}