<?php

declare(strict_types=1);

namespace App\Shared\Domain\Application\ExceptionResponses;

use InvalidArgumentException;
use App\Shared\Domain\Response;

final class InvalidArgumentExceptionResponse implements Response
{
    public function __construct(private readonly InvalidArgumentException $exception)
    {
    }

    public function toArray(): array
    {
        return [
            'message' => $this->exception->getMessage(),
        ];
    }
}
