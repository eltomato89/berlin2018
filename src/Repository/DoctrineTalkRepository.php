<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Talk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineTalkRepository extends ServiceEntityRepository implements TalkRepository
{
    public function __construct(RegistryInterface $doctrine)
    {
        parent::__construct($doctrine, Talk::class);
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function get(string $id): ?Talk
    {
        return $this->find($id);
    }

    public function add(Talk $talk): void
    {
        $this->getEntityManager()->persist($talk);
        $this->getEntityManager()->flush($talk);
    }

    public function remove(Talk $talk): void
    {
        $this->getEntityManager()->remove($talk);
        $this->getEntityManager()->flush($talk);
    }
}
