<?php

declare(strict_types=1);

namespace App\Controller\API\Players;

use App\Modules\Players\Application\Create\PlayerCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class PostPlayerController
{
    public function __construct(private readonly PlayerCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $requestData = $this->formatRequest($request);
        $errors = $this->validateRequest($requestData);

        if ($errors->count() > 0) {
            // TODO: handle errors.
            return new JsonResponse(
                [
                    "message" => $errors->get(0)->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $playerResponse = $this->creator->create(...array_values($requestData));

        return new JsonResponse($playerResponse->toArray(), status: Response::HTTP_CREATED);
    }

    private function validateRequest(array $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'       => [new Assert\IsNull(), new Assert\Uuid()],
                'name'     => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 255])],
            ]
        );

        return Validation::createValidator()->validate($request, $constraint);
    }

    private function formatRequest(Request $request): array
    {
        $formattedRequest = json_decode($request->getContent(), true);
        if (!is_array($formattedRequest)) {
            return [];
        }

        return $formattedRequest;
    }
}
