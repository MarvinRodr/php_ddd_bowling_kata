<?php

declare(strict_types=1);

namespace App\Modules\Players\Application;

use App\Shared\Domain\Response;

final class PlayerScoreResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
