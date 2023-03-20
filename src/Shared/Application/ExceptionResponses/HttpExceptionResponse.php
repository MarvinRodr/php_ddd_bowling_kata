<?php

declare(strict_types=1);

namespace App\Shared\Domain\Application\ExceptionResponses;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Shared\Domain\Response;

final class HttpExceptionResponse implements Response
{
    public function __construct(private readonly HttpException $exception)
    {
    }

    public function toArray(): array
    {
        return [
            'message' => $this->exception->getMessage(),
        ];
    }
}
