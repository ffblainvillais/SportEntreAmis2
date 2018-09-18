<?php

namespace App\Repository;

use App\Entity\Establishment;
use App\Entity\Sport;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EstablishmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Establishment::class);
    }

    /**
     * Return Establishment of User
     *
     * @param User $user
     * @return null|object
     */
    public function getEstablishementOfUser(User $user)
    {
        return $this->findOneBy(['user' => $user]);
    }

    /**
     * Return Establishment available for department and Sports
     *
     * @param string $postalCode
     * @param null|array $sports
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getEstablishmentWithPostalCodeAndSport($postalCode, $sports = null)
    {
        $query = "
            SELECT DISTINCT e.id
            FROM `establishments` e
            LEFT JOIN `grounds` g ON e.id = g.establishment_id
            LEFT JOIN `sports` s ON g.sport_id = s.id
            WHERE s.name IN (?) AND e.postal_code LIKE (?)
            ";

        if (!$sports) {
            $sports = $this->_em->getRepository(Sport::class)->getAllSportsName();
        }

        $connexion  = $this->_em->getConnection();
        $stmt       = $connexion->executeQuery($query, array($sports, $postalCode . "%"), array(\Doctrine\DBAL\Connection::PARAM_STR_ARRAY, \PDO::PARAM_STR));
        
        $establishments = $stmt->fetchAll();

        return $establishments;
    }

    /**
     * Return Sports available for an Establishment
     *
     * @param Establishment $establishment
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getSportAvailableForEstablishment(Establishment $establishment)
    {
        $query = "
            SELECT DISTINCT s.id
            FROM `establishments` e
            LEFT JOIN `grounds` g ON e.id = g.establishment_id
            LEFT JOIN `sports` s ON g.sport_id = s.id
            WHERE e.id = :establishmentId
            ";

        $connexion  = $this->_em->getConnection();
        $stmt       = $connexion->prepare($query);
        $stmt->bindValue(':establishmentId', $establishment->getId());
        $stmt->execute();

        $sports = $stmt->fetchAll();

        return $sports;
    }
}
