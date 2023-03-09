<?php

declare(strict_types=1);

namespace App\Controller\Players;

use App\Modules\Players\Application\PlayerScoreResponse;
use App\Modules\Players\Application\Score\PlayerScoreFinder;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetPlayerScoreController
{
    public function __construct(private readonly PlayerScoreFinder $finder)
    {
    }

    public function __invoke(string $player_id): JsonResponse
    {
        if (!$this->validateRequest($player_id)) {
            // TODO: handle errors.
            return new JsonResponse(
                [
                    "message" => "Invalid ID provided."
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $score = $this->finder->find($player_id);

        return new JsonResponse(
            (new PlayerScoreResponse($player_id, $score))->toArray(),
            status: Response::HTTP_OK
        );
    }

    private function validateRequest(string $player_id): bool
    {
        return Uuid::isValid($player_id);
    }
}
