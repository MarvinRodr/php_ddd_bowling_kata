<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Launches\Application\Calc\StrikeScoreCalculator;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Tests\Modules\Launches\Domain\LaunchesMother;
use App\Tests\Modules\Launches\Domain\LaunchMother;
use App\Tests\Modules\Launches\LaunchModuleUnitTestCase;

final class StrikeScoreCalculatorTest extends LaunchModuleUnitTestCase
{
    private StrikeScoreCalculator|null $calculator;

    protected function setUp(): void
    {
        $currentLaunch = LaunchMother::create(
            first_one: new LaunchFirstOne(10),
            second_one: new LaunchSecondOne(0),
            num_frame: new LaunchNumFrame(1)
        );
        $currentFrame = 0;
        $launches = LaunchesMother::create(
            2,
            collect(
                [
                    // Spare
                    $currentLaunch,
                    // Normal launch
                    LaunchMother::create(
                        first_one: new LaunchFirstOne(5),
                        second_one: new LaunchSecondOne(2),
                        num_frame: new LaunchNumFrame(2)
                    ),
                ]
            )->all()
        );

        $this->calculator = new StrikeScoreCalculator(
            launches: $launches,
            currentLaunch: $currentLaunch,
            currentFrame: $currentFrame
        );
        parent::setUp();
    }

    /**
     * @test
     *
     * Taking into account that the calculation is related with
     * the frame total pins knocked plus the bonus.
     *
     * Current example:
     * (10+0 (Strike!) + (5 + 2)) = 17 points (10 + bonus of 7)..
     */
    public function it_should_calc_with_an_strike_successfully(): void
    {
        $expectedScore = 17;
        $score = $this->calculator->calc();

        $this->assertEquals($expectedScore, $score);
    }
}
