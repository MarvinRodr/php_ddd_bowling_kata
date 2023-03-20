<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Players\Application\Create\PlayerCreator;
use App\Modules\Players\Application\Exceptions\PlayerAlreadyExistsHttpException;
use App\Tests\Modules\Players\Domain\PlayerMother;
use App\Tests\Modules\Players\PlayersModuleUnitTestCase;
use Ramsey\Uuid\Uuid;

final class PlayerCreatorTest extends PlayersModuleUnitTestCase
{
    private PlayerCreator|null $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new PlayerCreator($this->playerRepository());
    }

    /** @test */
    public function it_should_create_a_player(): void
    {
        $player = PlayerMother::create();
        $this->shouldSave($player);

        $this->creator->create($player->id()->toString(), $player->name()->value());
    }

    /** @test */
    public function it_should_not_create_a_player_and_throw_player_already_exists_http_exception(): void
    {
        $existingPlayerId =  Uuid::fromString('9809905c-bf7c-11ed-a136-0242ac180003');
        $player = PlayerMother::create(id: $existingPlayerId);
        $this->shouldThrowExceptionWhenTriesToSave($player, new PlayerAlreadyExistsHttpException($existingPlayerId));

        try {
            $this->creator->create($player->id()->toString(), $player->name()->value());
        } catch (PlayerAlreadyExistsHttpException $e) {
        }
    }
}
