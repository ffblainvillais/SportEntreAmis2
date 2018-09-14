<?php

namespace App\Repository;

use App\Entity\Establishment;
use App\Entity\Ground;
use App\Entity\Sport;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstablishmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Establishment::class);
    }

    public function getEstablishementOfUser(User $user)
    {
        return $this->findOneBy(['user' => $user]);
    }

    public function getEstablishmentWithPostalCodeAndSport($department, $sports)
    {
        $query = "
            SELECT DISTINCT e.id
            FROM `establishments` e
            LEFT JOIN `grounds` g ON e.id = g.establishment_id
            LEFT JOIN `sports` s ON g.sport_id = s.id
            WHERE s.name IN (?) AND e.postal_code LIKE (?)
            ";

        $connexion  = $this->_em->getConnection();
        $stmt       = $connexion->executeQuery($query, array($sports, substr($department,  0, 2) . "%"), array(\Doctrine\DBAL\Connection::PARAM_STR_ARRAY, \PDO::PARAM_STR));
        
        $establishments = $stmt->fetchAll();

        return $establishments;
    }

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
