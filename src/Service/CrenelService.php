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
                "beginHour" => $crenel['beginHour'],
                "endHour"   => $crenel['endHour'],
                "daysInfo"  => array(),
            );

            $crenelsOfWeekForThisHour = $this->em->getRepository(Crenel::class)->findBy(['beginHour' => $crenel['beginHour'], 'endHour' => $crenel['endHour']]);

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

        $this->_removeOldEstablishmentCrenels($establishmentOpeningHour);

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

    private function _removeOldEstablishmentCrenels(OpeningHour $openingHour)
    {
        $crenels = $openingHour->getCrenels();

        if (!empty($crenels)) {

            foreach ($crenels as $crenel) {
                $openingHour->removeCrenel($crenel);
            }

            $this->em->persist($openingHour);
            $this->em->flush();
        }
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

    public function getOpeningHoursToStringForEstablishment(Establishment $establishment)
    {
        $days                       = $this->em->getRepository(Day::class)->findAll();
        $establishmentOpeningHour   = $this->_getEstablishmentOpeningHour($establishment);
        $openingHours               = array();

        foreach ($days as $day) {

            $openingHoursForDay             = $establishmentOpeningHour->getCrenelsForDay($day);
            $openingHours[$day->getName()]  = $this->_getCrenelsIntervalsForDay($openingHoursForDay);
        }

        if (!empty($openingHours)) {

            $openingHours = $this->_stringifyOpeningHours($openingHours);
        }

        return $openingHours;
    }

    private function _getCrenelsIntervalsForDay($crenelsForDay)
    {
        if (!empty($crenelsForDay)) {

            $opengingHours      = array();
            $i                  = 0;
            $currentBeginHour   = $crenelsForDay[0]->getBeginHour();

            while ($i < sizeof($crenelsForDay)) {

                $currentEndHour = $crenelsForDay[$i]->getEndHour();

                if (!isset($crenelsForDay[$i + 1])) {

                    $opengingHours[]    = array(
                        'begin' => $currentBeginHour,
                        'end'   => $crenelsForDay[$i]->getEndHour(),
                    );

                } elseif ($crenelsForDay[$i + 1]->getBeginHour() != $currentEndHour) {

                    $lastEndHour        = $crenelsForDay[$i]->getEndHour();
                    $opengingHours[]    = array(
                        'begin' => $currentBeginHour,
                        'end'   => $lastEndHour,
                    );

                    $currentBeginHour  = $crenelsForDay[$i + 1]->getBeginHour();
                }

                $i++;
            }
            return $opengingHours;
        }

        return array();
    }

    private function _stringifyOpeningHours($openingHours)
    {
        $toRender = array();

        if (!empty($openingHours)) {

            foreach ($openingHours as $day => $intervals) {

                $sentence = " : ";

                if (!empty($intervals)) {

                    foreach ($intervals as $interval) {

                        $sentence .= $interval['begin'] . "h - " . $interval['end'] . "h ";
                    }
                }

                $toRender[] =  array(
                    'day'      => $day,
                    'sentence' => $sentence
                );
            }
        }

        return $toRender;
    }
}