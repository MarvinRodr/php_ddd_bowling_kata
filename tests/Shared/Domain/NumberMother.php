<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class NumberMother
{
    public static function create(): int
    {
        return MotherCreator::random()->randomNumber();
    }

    public static function createRandomBetween(int $int1, int $int2): int
    {
        return MotherCreator::random()->numberBetween($int1, $int2);
    }
}
