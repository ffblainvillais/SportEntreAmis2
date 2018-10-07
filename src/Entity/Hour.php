<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Day;

/**
 * @ORM\Entity
 * @ORM\Table(name="hours")
 */
class Hour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $beginHour;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $endHour;

    /**
     * @var smallint
     *
     * @ORM\Column(type="smallint")
     */
    private $isReserved;

    /**
     * @var smallint
     *
     * @ORM\Column(type="smallint")
     */
    private $isInEstablishmentOpeningHour;

    /**
     * Many Ground have One Establishment.
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="hours")
     * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
     */
    private $day;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBeginHour()
    {
        return $this->beginHour;
    }

    /**
     * @param string $beginHour
     */
    public function setBeginHour($beginHour)
    {
        $this->beginHour = $beginHour;
    }

    /**
     * @return string
     */
    public function getEndHour()
    {
        return $this->endHour;
    }

    /**
     * @param string $endHour
     */
    public function setEndHour($endHour)
    {
        $this->endHour = $endHour;
    }

    /**
     * @return smallint
     */
    public function getisReserved(): smallint
    {
        return $this->isReserved;
    }

    /**
     * @param smallint $isReserved
     */
    public function setIsReserved(smallint $isReserved)
    {
        $this->isReserved = $isReserved;
    }

    /**
     * @return smallint
     */
    public function getisInEstablishmentOpeningHour()
    {
        return $this->isInEstablishmentOpeningHour;
    }

    /**
     * @param smallint $isInEstablishmentOpeningHour
     */
    public function setIsInEstablishmentOpeningHour( $isInEstablishmentOpeningHour)
    {
        $this->isInEstablishmentOpeningHour = $isInEstablishmentOpeningHour;
    }

    /**
     * Get Bookings
     *
     * @return ArrayCollection
     */
    public function getDay()
    {
        return $this->day;
    }

    public function setDay(Day $day)
    {
        $this->day = $day;
    }

}
