<?php

namespace App\Service;

use App\Entity\Crenel;
use App\Entity\Day;
use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class CrenelService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getCrenelByHour(Establishment $establishment, $openingHourPage = false)
    {
        $crenels    = $this->em->getRepository(Crenel::class)->findAll();
        $toRender   = array();

        foreach ($crenels as $crenel) {

            $crenelInfo = array(
                "id"        => $crenel->getId(),
                "beginHour" => $crenel->getBeginHour(),
                "endHour"   => $crenel->getEndHour(),
                "daysInfo"  => array(),
            );

            foreach ($crenel->getDays() as $crenelDay) {

                $crenelInfo['daysInfo'][$crenelDay->getId()] = array(
                    "isReservable"                  => $openingHourPage ? true : $this->_canReserveCrenel($establishment, $crenel, $crenelDay),
                    "isInEstablishmentOpeningHour"  => $openingHourPage ? true : $this->_isOpenCrenelForEstablishment($establishment, $crenel, $crenelDay),
                );
            }

            $toRender[] = $crenelInfo;
        }

        return $toRender;
    }

    private function _canReserveCrenel(Establishment $establishment, Crenel $crenel, Day $crenelDay)
    {

    }

    private function _isOpenCrenelForEstablishment(Establishment $establishment, Crenel $crenel, Day $crenelDay)
    {

    }

    public function getStructure()
    {
        return array(
            8 => array(
                "Lundi" => array(
                    "isReservable"                  => true,
                    "isInEstablishmentOpeningHour"  => true,
                ),
                "Mardi" => array(
                    "isReservable"                  => true,
                    "isInEstablishmentOpeningHour"  => true,
                ),
            ),
            9 => array(
                "Lundi" => array(
                    "isReservable"                  => true,
                    "isInEstablishmentOpeningHour"  => true,
                ),
                "Mardi" => array(
                    "isReservable"                  => true,
                    "isInEstablishmentOpeningHour"  => true,
                ),
            )
        );
    }


    public function getCrenelMappedByDay2($openingHourPage = false)
    {
        $days       = $this->em->getRepository(Day::class)->findAll();
        $toRender   = array();

        foreach ($days as $day) {

            $dayCrenels = $day->getCrenels();

            foreach ($dayCrenels as $dayCrenel) {

                $toRender[$day->getName()][$dayCrenel->getBeginHour()] = $this->_getInformationCrenel($dayCrenel);
            }

        }

        return $toRender;
    }

    private function _getInformationCrenel(Crenel $dayCrenel)
    {
        return array(
            "isReservable"                  => true,
            "isInEstablishmentOpeningHour"  => true,
        );
    }
}