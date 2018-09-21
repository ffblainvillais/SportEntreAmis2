<?php

namespace App\Service;

use App\Entity\Crenel;
use App\Entity\Day;
use App\Entity\Establishment;
use App\Entity\OpeningHour;
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
        $crenels    = $this->em->getRepository(Crenel::class)->getDistinctedCrenels();
        $toRender   = array();

        foreach ($crenels as $crenel) {

            $crenelInfo = array(
                "id"        => $crenel->getId(),
                "beginHour" => $crenel->getBeginHour(),
                "endHour"   => $crenel->getEndHour(),
                "daysInfo"  => array(),
            );

            $crenelsOfWeekForThisHour = $this->em->getRepository(Crenel::class)->findBy(['beginHour' => $crenel->getBeginHour(), 'endHour' => $crenel->getEndHour()]);

            foreach ($crenelsOfWeekForThisHour as $dayCrenel) {

                $crenelInfo['daysInfo'][$dayCrenel->getDay()->getId()] = array(
                    "isReservable"                  => $openingHourPage ? true : $this->_canReserveCrenel($establishment, $dayCrenel),
                    "isInEstablishmentOpeningHour"  => $this->_isOpenCrenelForEstablishment($establishment, $dayCrenel),
                );
            }

            $toRender[] = $crenelInfo;
        }

        return $toRender;
    }

    private function _canReserveCrenel(Establishment $establishment, Crenel $crenel)
    {

    }

    private function _isOpenCrenelForEstablishment(Establishment $establishment, Crenel $crenel)
    {
        $establishmentOpeningHour = $this->_getEstablishmentOpeningHour($establishment);

        if ($establishmentOpeningHour && $establishmentOpeningHour->getCrenels()->contains($crenel)) {
            return true;
        }

        return false;
    }

    public function addOpeningHours($selectedCrenels, Establishment $establishment)
    {
        $establishmentOpeningHour   = $this->_getEstablishmentOpeningHour($establishment);
        $res                        = false;

        foreach ($selectedCrenels as $crenel) {

            if (isset($crenel["day"]) && isset($crenel['crenelBeginHour'])) {

                $day            = $this->em->getRepository(Day::class)->findOneBy(['id' => $crenel['day']]);
                $openingCrenel  = $this->em->getRepository(Crenel::class)->findOneBy(['day' => $day, 'beginHour' => $crenel['crenelBeginHour']]);

                if ($openingCrenel && $establishmentOpeningHour && !$establishmentOpeningHour->getCrenels()->contains($openingCrenel)) {

                    $establishmentOpeningHour->addCrenel($openingCrenel);

                    $this->em->persist($establishmentOpeningHour);
                    $res = true;
                }
            }
        }

        $this->em->flush();

        return $res;
    }

    private function _getEstablishmentOpeningHour(Establishment $establishment)
    {
        $openingHour = $this->em->getRepository(OpeningHour::class)->findOneBy(['establishment' => $establishment]);

        if (!$openingHour) {

            $openingHour = new OpeningHour();
            $openingHour->setEstablishment($establishment);

            $this->em->persist($openingHour);
            $this->em->flush();
        }

        return $openingHour;

    }
}