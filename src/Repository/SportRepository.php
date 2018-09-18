<?php

namespace App\Repository;

use App\Entity\Ground;
use App\Entity\Sport;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sport::class);
    }

    /**
     * Return all Sport
     *
     * @return array
     */
    public function getAllSports()
    {
        return $this->findAll();
    }

    /**
     * Return all Sport names
     *
     * @return array
     */
    public function getAllSportsName()
    {
        $sportsName = array();
        $sports     = $this->findAll();

        foreach ($sports as $sport) {
            $sportsName[] = $sport->getName();
        }

        return $sportsName;
    }
}
