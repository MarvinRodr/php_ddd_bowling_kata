<?php

declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\PhpUnit;

use App\Shared\Domain\UuidGenerator;
use App\Tests\Shared\Domain\TestUtils;
use Mockery\Matcher\MatcherAbstract;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery;

abstract class UnitTestCase extends MockeryTestCase
{
    private UuidGenerator|MockInterface|null $uuidGenerator;

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function uuidGenerator(): UuidGenerator|MockInterface
    {
        return $this->uuidGenerator = $this->uuidGenerator ?? $this->mock(UuidGenerator::class);
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()
            ->shouldReceive('generate')
            ->once()
            ->withNoArgs()
            ->andReturn($uuid);
    }


    protected function isSimilar($expected, $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo($value, $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }
}