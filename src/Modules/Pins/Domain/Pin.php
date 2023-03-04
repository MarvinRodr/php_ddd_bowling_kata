<?php

declare(strict_types=1);

namespace App\Modules\Pins\Domain;

use App\Modules\Pins\Domain\ValueObjects\PinId;

final class Pin
{
    public function __construct(
        private readonly PinId $id
    ) {
    }

    public static function create(PinId $id): self
    {
        return new self($id);
    }

    public function id(): PinId
    {
        return $this->id;
    }
}