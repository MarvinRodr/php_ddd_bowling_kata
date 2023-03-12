<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Score;

use App\Modules\Launches\Application\Calc\SpareScoreCalculator;
use App\Modules\Launches\Application\Calc\StrikeScoreCalculator;
use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchRepository;
use App\Modules\Players\Domain\PlayerRepository;
use Ramsey\Uuid\Uuid;

final class PlayerScoreFinder
{
    public function __construct(
        private readonly LaunchRepository $launchRepository,
        private readonly PlayerRepository $playerRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function find(string $player_id): int
    {
        $playerId = Uuid::fromString($player_id);

        $player = $this->playerRepository->findById($playerId);

        if (is_null($player)) {
            throw new \Exception("Player does not exist.");
        }

        $launches = $this->launchRepository->findByPlayerId($player->id())
            ->getCollection()
            ->sortBy(
                fn (Launch $launch) => $launch->numFrame()->value() // Because of problem with "orderBy" in DoctrineLaunchRepository
            )
        ;

        if ($launches->isEmpty()) {
            return 0;
        }

        return $launches->map(
            function (Launch $launch, int $index) use ($launches): int {
                if ($launch->isBonusLaunch()) {
                    return $launch->totalPinsKnocked();
                } elseif ($launch->isStrike()) {
                    return (new StrikeScoreCalculator($launches, $launch, $index))->calc();
                } elseif ($launch->isSpare()) {
                    return (new SpareScoreCalculator($launches, $launch, $index))->calc();
                } else {
                    return $launch->totalPinsKnocked();
                }
            }
        )->sum();
    }
}
