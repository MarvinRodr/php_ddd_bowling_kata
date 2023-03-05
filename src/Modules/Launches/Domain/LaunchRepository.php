<?php

declare(strict_types=1);

namespace App\Modules\Launches\Domain;

interface LaunchRepository
{
    public function save(Launch $launch): void;
}
