<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Domain;

use Ramsey\Uuid\Uuid;
use App\Tests\Shared\Domain\UuidMother;
use Ramsey\Uuid\UuidInterface;

final class PlayerIdMother
{
    public static function create(?string $value = null): UuidInterface
    {
        return Uuid::fromString($value ?? UuidMother::create());
    }
}
