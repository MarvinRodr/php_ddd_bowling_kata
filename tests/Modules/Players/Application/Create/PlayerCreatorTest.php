<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Players\Application\Create\PlayerCreator;
use App\Tests\Modules\Players\Domain\PlayerMother;
use App\Tests\Modules\Players\PlayersModuleUnitTestCase;

final class PlayerCreatorTest extends PlayersModuleUnitTestCase
{
    private PlayerCreator|null $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new PlayerCreator($this->repository());
    }

    /** @test */
    public function it_should_create_a_player(): void
    {
        $player = PlayerMother::create();
        $this->shouldSave($player);

        $this->creator->create($player->id()->value(), $player->name()->value());
    }
}