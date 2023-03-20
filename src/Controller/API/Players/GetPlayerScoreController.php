<?php

declare(strict_types=1);

namespace App\Controller\API\Players;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Modules\Players\Application\PlayerScoreResponse;
use App\Modules\Players\Application\Score\PlayerScoreFinder;
use App\Modules\Players\Application\Exceptions\PlayerNotFoundHttpException;
use App\Shared\Domain\Application\ExceptionResponses\ExceptionResponse;
use App\Shared\Domain\Application\ExceptionResponses\HttpExceptionResponse;
use Exception;

final class GetPlayerScoreController
{
    public function __construct(private readonly PlayerScoreFinder $finder)
    {
    }

    public function __invoke(string $player_id): JsonResponse
    {
        if (!$this->validateRequest($player_id)) {
            return new JsonResponse(
                (new ExceptionResponse(new Exception("Invalid ID provided.")))->toArray(),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $score = $this->finder->find($player_id);
        } catch (PlayerNotFoundHttpException $e) {
            return new JsonResponse((new HttpExceptionResponse($e))->toArray(), $e->getStatusCode());
        } catch (Exception $e) {
            return new JsonResponse((new ExceptionResponse($e))->toArray(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

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
