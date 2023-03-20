<?php

declare(strict_types=1);

namespace App\Modules\Launches\Application\Create;

use App\Modules\Launches\Application\LaunchResponse;
use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchRepository;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Launches\Domain\LaunchThirdOne;
use App\Modules\Players\Application\Exceptions\PlayerNotFoundHttpException;
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
     * @throws PlayerNotFoundHttpException
     */
    public function create(?string $id, ?string $player_id, int $first_one, int $second_one, int $third_one, int $num_frame): LaunchResponse
    {
        $launchId = is_null($id) ? Uuid::uuid1() : Uuid::fromString($id);
        $playerId = is_null($player_id) ? Uuid::uuid1() : Uuid::fromString($player_id);

        $player = $this->playerRepository->findById($playerId);

        if (is_null($player)) {
            throw new PlayerNotFoundHttpException($playerId);
        }

        $launch = new Launch(
            id: $launchId,
            player: $player,
            first_one: new LaunchFirstOne($first_one),
            second_one: new LaunchSecondOne($second_one),
            third_one: new LaunchThirdOne($third_one),
            num_frame: new LaunchNumFrame($num_frame)
        );

        $this->launchRepository->save($launch);

        return new LaunchResponse($launch);
    }
}
