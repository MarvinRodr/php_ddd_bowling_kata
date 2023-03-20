<?php

declare(strict_types=1);

namespace App\Controller\API\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Shared\Domain\RandomNumberGenerator;

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
