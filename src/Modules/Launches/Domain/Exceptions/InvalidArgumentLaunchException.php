<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain\Exceptions;

use InvalidArgumentException;

class InvalidArgumentLaunchException extends InvalidArgumentException
{
    /**
     * Bad request 400.
     *
     * @param $message
     * @param $code
     */
    public function __construct(protected $message, protected $code = 400)
    {
        parent::__construct($message, $code);
    }
}
