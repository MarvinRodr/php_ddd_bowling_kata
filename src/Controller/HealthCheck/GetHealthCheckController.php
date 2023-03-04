<?php

declare(strict_types=1);

namespace App\Controller\HealthCheck;

use App\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetHealthCheckController
{

    public function __construct(private readonly RandomNumberGenerator $generator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'HealthCheck' => 'ok',
                'rand'  => $this->generator->getOne(),
            ]
        );
    }
}