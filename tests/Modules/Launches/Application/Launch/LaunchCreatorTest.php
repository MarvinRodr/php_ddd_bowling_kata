<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Launches\Application\Create\LaunchCreator;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Tests\Modules\Launches\Domain\LaunchMother;
use App\Tests\Modules\Launches\LaunchModuleUnitTestCase;

final class LaunchCreatorTest extends LaunchModuleUnitTestCase
{
    private LaunchCreator|null $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new LaunchCreator(
            $this->launchRepository(),
            $this->playerRepository()
        );
    }

    /** @test */
    public function it_should_create_a_launch(): void
    {
        $launch = LaunchMother::create(
            first_one: new LaunchFirstOne(4),
            second_one: new LaunchSecondOne(6),
            num_frame: new LaunchNumFrame(1)
        );
        $this->playerRepositoryShouldFind($launch->player());
        $this->launchRepositoryShouldSave($launch);

        try {
            $this->creator->create(
                $launch->id()->toString(),
                $launch->player()->id()->toString(),
                $launch->firstOne()->value(),
                $launch->secondOne()->value(),
                $launch->numFrame()->value()
            );
        } catch (\Exception $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }
}
