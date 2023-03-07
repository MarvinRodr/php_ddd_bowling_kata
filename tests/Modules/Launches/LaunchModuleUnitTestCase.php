<?php

declare(strict_types=1);

namespace App\Tests\Modules\Launches;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchRepository;
use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class LaunchModuleUnitTestCase extends UnitTestCase
{
    private LaunchRepository|MockInterface|null $launchRepository;
    private PlayerRepository|MockInterface|null $playerRepository;

    protected function launchRepositoryShouldSave(Launch $launch): void
    {
        $this->launchRepository()
            ->shouldReceive('save')
            ->with($this->similarTo($launch))
            ->once()
            ->andReturnNull();
    }

    protected function playerRepositoryShouldFind(Player $player): void
    {
        $this->launchRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($this->similarTo($player));
    }

    protected function launchRepository(): LaunchRepository|MockInterface
    {
        return $this->launchRepository = $this->launchRepository ?? $this->mock(LaunchRepository::class);
    }

    protected function playerRepository(): PlayerRepository|MockInterface
    {
        return $this->playerRepository = $this->playerRepository ?? $this->mock(PlayerRepository::class);
    }
}
