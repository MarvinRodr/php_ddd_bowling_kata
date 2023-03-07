<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players;

use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class PlayersModuleUnitTestCase extends UnitTestCase
{
    private PlayerRepository|MockInterface|null $repository;

    protected function shouldSave(Player $player): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($player))
            ->once()
            ->andReturnNull();
    }

    protected function repository(): PlayerRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(PlayerRepository::class);
    }
}
