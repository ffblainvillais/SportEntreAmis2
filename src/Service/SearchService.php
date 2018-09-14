<?php

namespace App\Service;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function searchEstablishment($department, $sports = null)
    {
        $establishments     = $this->em->getRepository(Establishment::class)->getEstablishmentWithPostalCodeAndSport($department, $sports);
        $establishmentMatch = array();

        foreach ($establishments as $establishment) {

            $establishmentMatch[] = $this->_getEstablishmentById($establishment['id']);
        }

        return $establishmentMatch;
    }

    private function _getEstablishmentById($id)
    {
        return $this->em->getRepository(Establishment::class)->find($id);
    }

}