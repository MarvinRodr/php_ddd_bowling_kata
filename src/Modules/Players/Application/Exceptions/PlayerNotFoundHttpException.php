<?php

declare(strict_types=1);

namespace App\Modules\Players\Application\Exceptions;

use Ramsey\Uuid\UuidInterface;

final class PlayerNotFoundHttpException extends PlayerHttpException
{
    /**
     * Conflict 409.
     *
     * @param UuidInterface $playerId
     * @param int $statusCode
     */
    public function __construct(
        private readonly UuidInterface $playerId,
        private readonly int $statusCode = 409
    ) {
        parent::__construct(
            $this->statusCode,
            sprintf("The player ID <%s> does not exist in the database", $this->playerId->toString())
        );
    }
}
