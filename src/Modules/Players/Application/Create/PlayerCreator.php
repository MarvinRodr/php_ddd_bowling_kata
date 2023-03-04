<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Create;

use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Modules\Players\Domain\ValueObjects\PlayerId;
use App\Modules\Players\Domain\ValueObjects\PlayerName;

final class PlayerCreator
{
    public function __construct(private readonly PlayerRepository $repository)
    {
    }
    public function create(string $id, string $name): void
    {
        $this->repository->save(
            new Player(
                new PlayerId($id),
                new PlayerName($name)
            )
        );
    }
}