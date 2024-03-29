<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain;

use App\Modules\Launches\Domain\Exceptions\InvalidArgumentBonusLaunchException;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentNormalLaunchException;
use App\Modules\Players\Domain\Player;
use App\Shared\Domain\Aggregate\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Launch extends AggregateRoot
{
    private const MAX_NUM_PINS_CAN_BE_BOWLED = 10;
    private const MAX_NUM_OF_FRAMES = 10;

    public function __construct(
        private readonly UuidInterface $id,
        private readonly Player $player,
        private readonly LaunchFirstOne $first_one,
        private readonly LaunchSecondOne $second_one,
        private readonly LaunchThirdOne $third_one,
        private readonly LaunchNumFrame $num_frame
    ) {
        $this->ensureIsValidLaunch();
    }

    public static function create(
        UuidInterface $id,
        Player $player,
        LaunchFirstOne $first_one,
        LaunchSecondOne $second_one,
        LaunchThirdOne $third_one,
        LaunchNumFrame $num_frame
    ): self {
        return new self($id, $player, $first_one, $second_one, $third_one, $num_frame);
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function player(): Player
    {
        return $this->player;
    }

    public function firstOne(): LaunchFirstOne
    {
        return $this->first_one;
    }

    public function secondOne(): LaunchSecondOne
    {
        return $this->second_one;
    }

    public function thirdOne(): LaunchThirdOne
    {
        return $this->third_one;
    }

    public function numFrame(): LaunchNumFrame
    {
        return $this->num_frame;
    }

    private function isValidLaunch(): bool
    {
        return (($this->firstOne()->value() + $this->secondOne()->value()) <= self::MAX_NUM_PINS_CAN_BE_BOWLED)
            && $this->numFrame()->isLessOrEqualThan(self::MAX_NUM_OF_FRAMES)
            && !$this->numFrame()->isZero();
    }

    public function isStrike(): bool
    {
        return $this->firstOne()->isEqualTo(self::MAX_NUM_PINS_CAN_BE_BOWLED);
    }

    public function isSpare(): bool
    {
        return
            $this->firstOne()->isLessThan(self::MAX_NUM_PINS_CAN_BE_BOWLED)
            && (
                ($this->firstOne()->value() + $this->secondOne()->value()) === self::MAX_NUM_PINS_CAN_BE_BOWLED
            );
    }

    public function isBonusLaunch(): bool
    {
        return $this->numFrame()->value() === self::MAX_NUM_OF_FRAMES;
    }

    private function isValidBonusLaunch(): bool
    {
        return ($this->totalPinsKnocked() <= (self::MAX_NUM_PINS_CAN_BE_BOWLED * 3))
            && $this->numFrame()->isEqualTo(self::MAX_NUM_OF_FRAMES)
        ;
    }

    public function totalPinsKnocked(): int
    {
        return $this->firstOne()->value() + $this->secondOne()->value() + $this->thirdOne()->value();
    }

    public static function getMaxNumPinsCanBeBowled(): int
    {
        return self::MAX_NUM_PINS_CAN_BE_BOWLED;
    }

    public static function getMaxNumOfFrames(): int
    {
        return self::MAX_NUM_OF_FRAMES;
    }

    private function ensureIsValidLaunch(): void
    {
        $this->validateBonusLaunch();
        $this->validateLaunch();
    }

    private function validateBonusLaunch(): void
    {
        if (($this->isBonusLaunch() && !$this->isValidBonusLaunch())) {
            throw new InvalidArgumentBonusLaunchException($this->numFrame(), $this->totalPinsKnocked());
        }
    }

    private function validateLaunch(): void
    {
        if (!$this->isBonusLaunch() && !$this->isValidLaunch()) {
            throw new InvalidArgumentNormalLaunchException($this->numFrame(), $this->totalPinsKnocked());
        }
    }
}
