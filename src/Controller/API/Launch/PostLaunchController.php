<?php

declare(strict_types=1);

namespace App\Controller\API\Launch;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

use App\Modules\Launches\Application\Create\LaunchCreator;
use App\Modules\Launches\Domain\Launch;
use App\Modules\Players\Application\Exceptions\PlayerNotFoundHttpException;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentBonusLaunchException;
use App\Modules\Launches\Domain\Exceptions\InvalidArgumentNormalLaunchException;
use App\Shared\Domain\Application\ExceptionResponses\ExceptionResponse;
use App\Shared\Domain\Application\ExceptionResponses\HttpExceptionResponse;
use App\Shared\Domain\Application\ExceptionResponses\InvalidArgumentExceptionResponse;
use Exception;

final class PostLaunchController
{
    public function __construct(private readonly LaunchCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $requestData = $this->formatRequest($request);
        $errors = $this->validateRequest($requestData);

        if ($errors->count() > 0) {
            return new JsonResponse(
                (new ExceptionResponse(new Exception($errors->get(0)->getMessage())))->toArray(),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $launchResponse = $this->creator->create(...array_values($requestData));
        } catch (PlayerNotFoundHttpException $e) {
            return new JsonResponse((new HttpExceptionResponse($e))->toArray(), $e->getStatusCode());
        } catch (InvalidArgumentNormalLaunchException|InvalidArgumentBonusLaunchException $e) {
            return new JsonResponse((new InvalidArgumentExceptionResponse($e))->toArray(), $e->getCode());
        } catch (Exception $e) {
            return new JsonResponse((new ExceptionResponse($e))->toArray(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($launchResponse->toArray(), Response::HTTP_CREATED);
    }

    private function validateRequest(array $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'            => [new Assert\IsNull(), new Assert\Uuid()],
                'player_id'     => [new Assert\NotBlank(), new Assert\Uuid()],
                'first_one'     => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\Range(min:0, max: Launch::getMaxNumPinsCanBeBowled())],
                'second_one'    => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\Range(min:0, max: Launch::getMaxNumPinsCanBeBowled())],
                'third_one'     => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\Range(min:0, max: Launch::getMaxNumPinsCanBeBowled())],
                'num_frame'     => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\Range(min:1, max: Launch::getMaxNumOfFrames())],
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
