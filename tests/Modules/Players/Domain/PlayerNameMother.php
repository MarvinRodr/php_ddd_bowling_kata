<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Domain;

use App\Modules\Players\Domain\PlayerName;
use App\Tests\Shared\Domain\WordMother;

final class PlayerNameMother
{
    public static function create(?string $value = null): PlayerName
    {
        return new PlayerName($value ?? WordMother::create());
    }
}