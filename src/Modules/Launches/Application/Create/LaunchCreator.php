<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Create;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchRepository;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Players\Domain\PlayerRepository;
use Ramsey\Uuid\Uuid;

final class LaunchCreator
{
    public function __construct(
        private readonly LaunchRepository $launchRepository,
        private readonly PlayerRepository $playerRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function create(?string $id, ?string $player_id, int $first_one, int $second_one, int $num_frame): void {

        $launchId = is_null($id) ? Uuid::uuid1(): Uuid::fromString($id);
        $playerId = is_null($player_id) ? Uuid::uuid1(): Uuid::fromString($player_id);

        $player = $this->playerRepository->findById($playerId);

        if (is_null($player)) {
            // TODO: Custom Exceptions.
            throw new \Exception("Player does not exist.");
        }

        $this->launchRepository->save(
            new Launch(
                id: $launchId,
                player: $player,
                first_one: new LaunchFirstOne($first_one),
                second_one: new LaunchSecondOne($second_one),
                num_frame: new LaunchNumFrame($num_frame)
            )
        );
    }
}