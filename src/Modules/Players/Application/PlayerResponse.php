<?php

declare(strict_types=1);

namespace App\Players\Application;

use App\Shared\Domain\Response;

final class PlayerResponse implements Response
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

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
        ];
    }
}
