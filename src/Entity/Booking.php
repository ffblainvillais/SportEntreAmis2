<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bookings")
 */
class Booking
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
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime", nullable=false)
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     */
    private $endDate;

    /**
     * Many Booking are on only one Day.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Day")
     * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
     */
    private $day;

    /**
     * Many Booking are on only one Ground.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Ground")
     * @ORM\JoinColumn(name="ground_id", referencedColumnName="id")
     */
    private $ground;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
     * @return Ground
     */
    public function getGround()
    {
        return $this->ground;
    }

    /**
     * @param Ground $ground
     */
    public function setGround(Ground $ground)
    {
        $this->ground = $ground;
    }
}
