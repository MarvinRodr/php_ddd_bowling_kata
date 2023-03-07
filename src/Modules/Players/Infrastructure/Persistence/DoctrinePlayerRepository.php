<?php

declare(strict_types=1);

namespace App\Modules\Players\Infrastructure\Persistence;

use App\Modules\Players\Domain\Player;
use App\Modules\Players\Domain\PlayerRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Ramsey\Uuid\UuidInterface;

final class DoctrinePlayerRepository extends DoctrineRepository implements PlayerRepository
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Player $player): void
    {
        $this->persist($player);
    }

    public function findById(UuidInterface $id): ?Player
    {
        return $this->repository(Player::class)->find($id->toString());
    }
}