<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches\Domain;

use App\Tests\Shared\Domain\UuidMother;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class LaunchIdMother
{
    public static function create(?string $value = null): UuidInterface
    {
        return Uuid::fromString($value ?? UuidMother::create());
    }
}