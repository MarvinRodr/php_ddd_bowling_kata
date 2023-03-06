<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Domain;

use App\Modules\Players\Domain\PlayerId;
use App\Tests\Shared\Domain\UuidMother;

final class PlayerIdMother
{
    public static function create(?string $value = null): PlayerId
    {
        return new PlayerId($value ?? UuidMother::create());
    }
}