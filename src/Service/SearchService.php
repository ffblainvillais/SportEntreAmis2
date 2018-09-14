<?php

namespace App\Service;

use App\Entity\Establishment;
use App\Entity\Sport;
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

    public function mapEstablishmentWithSports($establishments)
    {
        $establishmentsMapped = array();

        foreach ($establishments as $establishment) {

            $establishmentInfo = array(
                "establishment"     => $establishment,
                "sportsAvailable"   => $this->_getSportAvailableForEstablishment($establishment),
            );

            $establishmentsMapped[] = $establishmentInfo;
        }

        return $establishmentsMapped;
    }

    private function _getSportAvailableForEstablishment(Establishment $establishment)
    {
        $sportsAvailableIds = $this->em->getRepository(Establishment::class)->getSportAvailableForEstablishment($establishment);
        $sportsAvailable    = array();

        foreach ($sportsAvailableIds as $sportsAvailableId) {

            $sport              = $this->_getSportById($sportsAvailableId['id']);
            $sportsAvailable[]  = $sport;
        }

        return $sportsAvailable;
    }

    private function _getEstablishmentById($id)
    {
        return $this->em->getRepository(Establishment::class)->find($id);
    }

    private function _getSportById($id)
    {
        return $this->em->getRepository(Sport::class)->find($id);
    }

}