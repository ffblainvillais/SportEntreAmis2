<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function autocomplete($part)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->add('select', 'd.name, d.code')
            ->add('from', 'App\Entity\Department d');

        if (is_numeric($part)) {

            $qb->where('d.code = :part');
            $qb->setParameter('part', substr($part, 0, 2));

        } elseif (is_string($part)) {

            $qb->where('d.name LIKE :part');
            $qb->setParameter('part', ucfirst($part) . "%");

        } else {

            return null;
        }

        $query      = $qb->getQuery();
        $results    = $query->getResult();

        return $results;
    }
}
