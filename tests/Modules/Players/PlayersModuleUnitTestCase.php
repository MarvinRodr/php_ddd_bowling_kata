<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players;

use App\Modules\Launches\Domain\LaunchRepository;
use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class PlayersModuleUnitTestCase extends UnitTestCase
{
    private PlayerRepository|MockInterface|null $playerRepository;
    private LaunchRepository|MockInterface|null $launchRepository;

    protected function shouldSave(Player $player): void
    {
        $this->playerRepository()
            ->shouldReceive('save')
            ->with($this->similarTo($player))
            ->once()
            ->andReturn($this->similarTo($player));
    }

    protected function shouldFindScore(int $expectedScore): void
    {
        $this->launchRepository()
            ->shouldReceive('findByPlayerId')
            ->once()
            ->andReturn($expectedScore);
    }

    protected function playerRepository(): PlayerRepository|MockInterface
    {
        return $this->playerRepository = $this->playerRepository ?? $this->mock(PlayerRepository::class);
    }

    protected function launchRepository(): LaunchRepository|MockInterface
    {
        return $this->launchRepository = $this->launchRepository ?? $this->mock(LaunchRepository::class);
    }
}
