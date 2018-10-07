<?php

namespace App\Repository;

use App\Entity\Crenel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CrenelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Crenel::class);
    }

    public function getDistinctedCrenels()
    {
        $qb = $this->createQueryBuilder("c");

        $crenels = $qb->select("DISTINCT c.beginHour, c.endHour")
            ->getQuery()
            ->getResult();

        return $crenels;
    }
}
