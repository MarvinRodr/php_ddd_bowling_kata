<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain\Exceptions;

use App\Modules\Players\Domain\PlayerName;

class InvalidPlayerNameException extends InvalidArgumentPlayerException
{
    public function __construct(private readonly PlayerName $playerName)
    {
        parent::__construct(sprintf("The player name <%s> is not valid", $this->playerName->value()));
    }
}
