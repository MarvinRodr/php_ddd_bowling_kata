<?php

declare(strict_types=1);

namespace App\Modules\Players\Domain\Exceptions;

use InvalidArgumentException;

class InvalidArgumentPlayerException extends InvalidArgumentException
{
    public function __construct(protected $message, protected $code = 400)
    {
        parent::__construct($message, $code);
    }
}
