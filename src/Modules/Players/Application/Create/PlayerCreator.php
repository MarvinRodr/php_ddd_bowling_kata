<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Create;

use App\Modules\Players\Application\Exceptions\PlayerAlreadyExistsHttpException;
use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Modules\Players\Domain\PlayerName;
use App\Modules\Players\Application\PlayerResponse;
use Ramsey\Uuid\Uuid;

final class PlayerCreator
{
    public function __construct(private readonly PlayerRepository $repository)
    {
    }

    /**
     * @param string|null $id
     * @param string $name
     *
     * @throws PlayerAlreadyExistsHttpException
     *
     * @return PlayerResponse
     */
    public function create(?string $id, string $name): PlayerResponse
    {
        $id = is_null($id) ? Uuid::uuid1() : Uuid::fromString($id);
        $player = new Player($id, new PlayerName($name));

        $playerExist = $this->repository->findById($player->id());

        // If player exists then throw exception.
        if ($playerExist instanceof Player) {
            throw new PlayerAlreadyExistsHttpException($playerExist->id());
        }

        // Save the new player.
        $this->repository->save($player);

        return new PlayerResponse($player->id()->toString(), $player->name()->value());
    }
}
