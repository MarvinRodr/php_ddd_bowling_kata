<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isBiggerThan(int $other): bool
    {
        return $this->value() > $other;
    }

    public function isEqualTo(int $other): bool
    {
        return $this->value() === $other;
    }

    public function isZero(): bool
    {
        return $this->value() === 0;
    }

    public function isLessThan(int $other): bool
    {
        return $this->value() < $other;
    }

    public function isLessOrEqualThan(int $other): bool
    {
        return $this->isLessThan($other) || $this->isEqualTo($other);
    }
}