<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="opening_hours")
 */
class OpeningHour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * Many OpeningHour has one Day
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Day")
     * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
     */
    private $day;

    /**
     * Many OpeningHour have One Establishment.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="openingHours")
     * @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     */
    private $establishment;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param Day $day
     */
    public function setDay(Day $day)
    {
        $this->day = $day;
    }

    /**
     * @return Establishment
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    /**
     * @param Establishment $establishment
     */
    public function setEstablishment(Establishment $establishment)
    {
        $this->establishment = $establishment;
    }


}
