<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Player extends AggregateRoot
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly PlayerName $name
    ) {
    }

    public static function create(
        UuidInterface $id,
        PlayerName $name
    ): self {
        return new self($id, $name);
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): PlayerName
    {
        return $this->name;
    }
}