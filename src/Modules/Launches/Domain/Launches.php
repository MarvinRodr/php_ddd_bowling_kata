<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain;

use App\Shared\Domain\Collection;

final class Launches extends Collection
{
    protected function type(): string
    {
        return Launch::class;
    }
}
