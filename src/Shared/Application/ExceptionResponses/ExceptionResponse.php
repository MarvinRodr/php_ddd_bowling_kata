<?php

declare(strict_types=1);

namespace App\Shared\Domain\Application\ExceptionResponses;

use Exception;
use App\Shared\Domain\Response;

final class ExceptionResponse implements Response
{
    public function __construct(private readonly Exception $exception)
    {
    }

    public function toArray(): array
    {
        return [
            'message' => $this->exception->getMessage(),
        ];
    }
}
