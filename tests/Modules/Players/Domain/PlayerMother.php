<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Domain;

use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerName;
use Ramsey\Uuid\UuidInterface;

class PlayerMother
{
    public static function create(
        ?UuidInterface $id = null,
        ?PlayerName $name = null
    ): Player {
        return new Player(
            $id ?? PlayerIdMother::create(),
            $name ?? PlayerNameMother::create()
        );
    }
}
