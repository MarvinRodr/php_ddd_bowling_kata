<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Create;

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
    public function create(?string $id, string $name): PlayerResponse
    {
        $id = is_null($id) ? Uuid::uuid1() : Uuid::fromString($id);

        $player = new Player($id, new PlayerName($name));
        $this->repository->save($player);

        return new PlayerResponse($player->id()->toString(), $player->name()->value());
    }
}
