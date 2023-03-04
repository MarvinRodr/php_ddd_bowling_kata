<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain;

use App\Modules\Players\Domain\ValueObjects\PlayerId;
use App\Modules\Players\Domain\ValueObjects\PlayerName;
use App\Shared\Domain\Aggregate\AggregateRoot;

final class Player extends AggregateRoot
{
    public function __construct(
        private readonly PlayerId $id,
        private readonly PlayerName $name
    ) {
    }

    public static function create(
        PlayerId $id,
        PlayerName $name
    ): self {
        return new self($id, $name);
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function name(): PlayerName
    {
        return $this->name;
    }
}