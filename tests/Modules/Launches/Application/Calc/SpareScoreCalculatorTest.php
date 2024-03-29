<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Launches\Application\Calc\SpareScoreCalculator;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Launches\Domain\LaunchThirdOne;
use App\Tests\Modules\Launches\Domain\LaunchesMother;
use App\Tests\Modules\Launches\Domain\LaunchMother;
use App\Tests\Modules\Launches\Domain\LaunchSpareMother;
use App\Tests\Modules\Launches\LaunchModuleUnitTestCase;

final class SpareScoreCalculatorTest extends LaunchModuleUnitTestCase
{
    private SpareScoreCalculator|null $calculator;

    protected function setUp(): void
    {
        $spare = LaunchSpareMother::create();
        $currentFrame = 0;
        $launches = LaunchesMother::create(
            2,
            collect(
                [
                    $spare,
                    // Normal launch
                    LaunchMother::create(
                        first_one: new LaunchFirstOne(5),
                        second_one: new LaunchSecondOne(2),
                        third_one: new LaunchThirdOne(0),
                        num_frame: new LaunchNumFrame(2)
                    ),
                ]
            )->all()
        );

        $this->calculator = new SpareScoreCalculator(
            launches: $launches->getCollection(),
            currentLaunch: $spare,
            index: $currentFrame
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
     * (9+1 (Spare!) + (5) (firstLaunch of the next one)) = 15 points (10 + bonus of 5).
     */
    public function it_should_calc_with_an_spare_successfully(): void
    {
        $expectedScore = 15;
        $score = $this->calculator->calc();

        $this->assertEquals($expectedScore, $score);
    }
}
