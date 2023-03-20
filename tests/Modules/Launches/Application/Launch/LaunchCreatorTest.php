<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Launches\Application\Create\LaunchCreator;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentBonusLaunchException;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentLaunchException;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentNormalLaunchException;
use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Launches\Domain\LaunchThirdOne;
use App\Modules\Players\Application\Exceptions\PlayerNotFoundHttpException;
use App\Tests\Modules\Launches\Domain\LaunchMother;
use App\Tests\Modules\Launches\LaunchModuleUnitTestCase;

final class LaunchCreatorTest extends LaunchModuleUnitTestCase
{
    private LaunchCreator|null $creator;

    private Launch|null $launch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new LaunchCreator(
            $this->launchRepository(),
            $this->playerRepository()
        );

        $this->launch = LaunchMother::create(
            first_one: new LaunchFirstOne(4),
            second_one: new LaunchSecondOne(6),
            third_one: new LaunchThirdOne(0),
            num_frame: new LaunchNumFrame(1)
        );
    }

    /** @test */
    public function it_should_create_a_launch(): void
    {
        $this->playerRepositoryShouldFind($this->launch->player());
        $this->launchRepositoryShouldSave($this->launch);

        try {
            $this->creator->create(
                $this->launch->id()->toString(),
                $this->launch->player()->id()->toString(),
                $this->launch->firstOne()->value(),
                $this->launch->secondOne()->value(),
                $this->launch->thirdOne()->value(),
                $this->launch->numFrame()->value()
            );
        } catch (\Exception $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }

    /** @test */
    public function it_should_not_create_a_launch_and_throw_player_not_found_http_exception(): void
    {
        $this->playerRepositoryShouldNotFindAndThrowsPlayerHttpException(
            $this->launch->player(),
            new PlayerNotFoundHttpException($this->launch->player()->id())
        );

        try {
            $this->creator->create(
                $this->launch->id()->toString(),
                $this->launch->player()->id()->toString(),
                $this->launch->firstOne()->value(),
                $this->launch->secondOne()->value(),
                $this->launch->thirdOne()->value(),
                $this->launch->numFrame()->value()
            );
        } catch (PlayerNotFoundHttpException $e) {
        }
    }

    /** @test */
    public function it_should_not_create_a_normal_launch_and_throw_invalid_argument_normal_launch_exception(): void
    {
        $badNumFrame = new LaunchNumFrame(Launch::getMaxNumOfFrames() + 1);
        $badTotalPinsKnocked = 15;
        $exception = new InvalidArgumentNormalLaunchException($badNumFrame, $badTotalPinsKnocked);
        $expected = null;

        try {
            LaunchMother::create(
                first_one: new LaunchFirstOne(10),
                second_one: new LaunchSecondOne(5),
                third_one: new LaunchThirdOne(0),
                num_frame: $badNumFrame
            );
        } catch (InvalidArgumentLaunchException $e) {
            $expected = $e;
        }

        $this->assertEquals($exception, $expected);
    }

    /** @test */
    public function it_should_not_create_a_bonus_launch_and_throw_invalid_argument_bonus_launch_exception(): void
    {
        $badNumFrame = new LaunchNumFrame(Launch::getMaxNumOfFrames());
        $badTotalPinsKnocked = 35;
        $exception = new InvalidArgumentBonusLaunchException($badNumFrame, $badTotalPinsKnocked);
        $expected = null;

        try {
            LaunchMother::create(
                first_one: new LaunchFirstOne(10),
                second_one: new LaunchSecondOne(10),
                third_one: new LaunchThirdOne(15),
                num_frame: $badNumFrame
            );
        } catch (InvalidArgumentBonusLaunchException $e) {
            $expected = $e;
        }

        $this->assertEquals($exception, $expected);
    }
}
