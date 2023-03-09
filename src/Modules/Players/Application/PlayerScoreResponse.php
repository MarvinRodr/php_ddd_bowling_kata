<?php

declare(strict_types=1);

namespace App\Modules\Players\Application;

use App\Shared\Domain\Response;

final class PlayerScoreResponse implements Response
{
    public function __construct(
        private readonly string $player_id,
        private readonly int $total_score
    ) {
    }

    public function playerID(): string
    {
        return $this->player_id;
    }

    public function totalScore(): int
    {
        return $this->total_score;
    }

    public function toArray(): array
    {
        return [
            'player_id' => $this->playerID(),
            'total_score' => $this->totalScore(),
        ];
    }
}
