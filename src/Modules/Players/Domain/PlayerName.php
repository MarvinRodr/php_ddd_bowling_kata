<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain;

use App\Modules\Players\Domain\Exceptions\InvalidPlayerNameException;
use App\Shared\Domain\ValueObject\StringValueObject;

class PlayerName extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->value = $value;

        $this->validate();
        parent::__construct($value);
    }

    private function validate(): void
    {
        if ($this->isBlank()) {
            throw new InvalidPlayerNameException($this);
        }
    }
}
