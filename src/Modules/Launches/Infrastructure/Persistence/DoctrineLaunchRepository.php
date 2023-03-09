<?php

declare(strict_types=1);

namespace App\Modules\Launches\Infrastructure\Persistence;

use App\Modules\Launches\Domain\Launch;
use App\Modules\Launches\Domain\Launches;
use App\Modules\Launches\Domain\LaunchRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Ramsey\Uuid\UuidInterface;

final class DoctrineLaunchRepository extends DoctrineRepository implements LaunchRepository
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Launch $launch): void
    {
        $this->persist($launch);
    }

    public function search(UuidInterface $id): ?Launch
    {
        return $this->repository(Launch::class)->find($id->toString());
    }

    public function findByPlayerId(UuidInterface $player_id): Launches
    {
        return new Launches(
            $this->repository(Launch::class)
            ->findBy(
                ['player' => $player_id->toString()],
                // ['LaunchNumFrame' => 'ASC'] ==> Problems with doctrine ORM and XML Mapping.
            )
        );
    }
}
