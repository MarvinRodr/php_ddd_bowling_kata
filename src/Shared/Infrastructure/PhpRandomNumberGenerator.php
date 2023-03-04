<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Domain\RandomNumberGenerator;

final class PhpRandomNumberGenerator implements RandomNumberGenerator
{
    /**
     * @throws \Exception
     */
    public function generate(): int
    {
        return random_int(1, 5);
    }

    public function getOne(): int
    {
        return 1;
    }
}
