<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use function Lambdish\Phunctional\repeat;

final class Repeater
{
    public static function repeat(callable $function, int $quantity): array
    {
        return repeat($function, $quantity);
    }
}
