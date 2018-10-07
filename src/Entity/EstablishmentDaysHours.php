<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Day;

/**
 * @ORM\Entity
 * @ORM\Table(name="establishment_days_hours")
 */
class EstablishmentDaysHours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var smallint
     *
     * @ORM\Column(type="smallint")
     */
    private $isOpen;

    /**
     * @var string
     *
     * @ORM\Column(type="smallint")
     */
    private $isReservable;

    /**
     * Many EstablishmentDaysHours serves only one Day.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Day")
     * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
     */
    private $days;

    /**
     * One EstablishmentDaysHours serves only one Hour.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hour")
     * @ORM\JoinColumn(name="hour_id", referencedColumnName="id")
     */
    private $hours;

    /**
     * One EstablishmentDaysHours serves only one Establishment.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="")
     * @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     */
    private $establishments;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return smallint
     */
    public function getisOpen(): smallint
    {
        return $this->isOpen;
    }

    /**
     * @param smallint $isOpen
     */
    public function setIsOpen(smallint $isOpen)
    {
        $this->isOpen = $isOpen;
    }

    /**
     * @return smallint
     */
    public function getisReservable(): smallint
    {
        return $this->isReservable;
    }

    /**
     * @param smallint $isReservable
     */
    public function setIsReservable(smallint $isReservable)
    {
        $this->isReservable = $isReservable;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    /**
     * @return mixed
     */
    public function getEstablishments()
    {
        return $this->establishments;
    }

    /**
     * @param mixed $establishments
     */
    public function setEstablishments($establishments)
    {
        $this->establishments = $establishments;
    }


}
