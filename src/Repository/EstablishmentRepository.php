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

    public function getEstablishmentWithPostalCodeAndSport($department)
    {
        $query = "
            SELECT DISTINCT e.id
            FROM `establishments` e
            LEFT JOIN `grounds` g ON e.id = g.establishment_id
            LEFT JOIN `sports` s ON g.sport_id = s.id
            WHERE e.postal_code LIKE :postalCode
            ";

        $connexion  = $this->_em->getConnection();
        $stmt       = $connexion->prepare($query);

        $stmt->bindValue(':postalCode', substr($department,  0, 2) . "%");
        $stmt->execute();
        
        echo "<pre style='background:#fff; color:#000'>";\Doctrine\Common\Util\Debug::dump($stmt->fetchAll());die();
        $establishments = $stmt->fetchAll();

        return $aBookMarks;
    }
}
