<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Score;

use App\Modules\Launches\Application\Calc\SpareScoreCalculator;
use App\Modules\Launches\Application\Calc\StrikeScoreCalculator;
use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchRepository;
use Ramsey\Uuid\Uuid;

final class PlayerScoreFinder
{
    public function __construct(private readonly LaunchRepository $repository)
    {
    }

    public function find(string $player_id): int
    {
        $player_id = Uuid::fromString($player_id);

        $launches = $this->repository->findByPlayerId($player_id);
        $launchesCollection = $launches->getCollection();

        if ($launchesCollection->isEmpty()) {
            return 0;
        }

        return $launchesCollection->map(
            function (Launch $launch, int $index) use ($launches): int {
                if ($launch->isSpare()) {
                    return (new SpareScoreCalculator($launches, $launch, $index))->calc();
                } elseif ($launch->isStrike()) {
                    return (new StrikeScoreCalculator($launches, $launch, $index))->calc();
                } else {
                    return $launch->totalPinsKnocked();
                }
            }
        )->sum();
    }
}
