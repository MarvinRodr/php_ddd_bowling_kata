<?php

declare(strict_types=1);

namespace App\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class PostPlayerController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
