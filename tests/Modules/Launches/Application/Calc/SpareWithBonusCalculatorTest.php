<?php

declare(strict_types=1);

namespace App\Tests\Modules\Players\Application\Create;

use App\Modules\Launches\Application\Calc\SpareScoreCalculator;
use App\Modules\Launches\Application\Calc\StrikeScoreCalculator;
use App\Modules\Launches\Domain\LaunchFirstOne;
use App\Modules\Launches\Domain\LaunchNumFrame;
use App\Modules\Launches\Domain\LaunchSecondOne;
use App\Modules\Launches\Domain\LaunchThirdOne;
use App\Tests\Modules\Launches\Domain\LaunchesMother;
use App\Tests\Modules\Launches\Domain\LaunchMother;
use App\Tests\Modules\Launches\Domain\LaunchSpareMother;
use App\Tests\Modules\Launches\LaunchModuleUnitTestCase;

final class SpareWithBonusCalculatorTest extends LaunchModuleUnitTestCase
{
    private SpareScoreCalculator|null $calculator;

    protected function setUp(): void
    {
        $strike = LaunchSpareMother::create();
        $currentIndex = 0;
        $launches = LaunchesMother::create(
            2,
            collect(
                [
                    $strike,
                    // Bonus launch
                    LaunchMother::create(
                        first_one: new LaunchFirstOne(10),
                        second_one: new LaunchSecondOne(10),
                        third_one: new LaunchThirdOne(10),
                        num_frame: new LaunchNumFrame(10)
                    ),
                ]
            )->all()
        );

        $this->calculator = new SpareScoreCalculator(
            launches: $launches->getCollection(),
            currentLaunch: $strike,
            index: $currentIndex
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
     * (10+0 (Strike!) + (10)) = 20 points (10 + bonus of 10)..
     *
     * @return void
     * @throws \Exception
     */
    public function it_should_calc_successfully_with_current_spare_and_next_one_is_bonus(): void
    {
        $expectedScore = 20;
        $score = $this->calculator->calc();

        $this->assertEquals($expectedScore, $score);
    }
}
