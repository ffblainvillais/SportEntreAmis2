<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Booking;

/**
 * @ORM\Entity
 * @ORM\Table(name="crenels")
 */
class Crenel
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
     * Many Crenel are on only one Day.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="crenels")
     * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
     */
    private $day;

    /**
     * Many Crenel have Many Booking.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Booking", mappedBy="crenels")
     */
    private $bookings;

    /**
     * Many Crenel have Many OpeningHour.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\OpeningHour", mappedBy="crenels")
     */
    private $openingHours;

    public function __construct()
    {
        $this->bookings     = new ArrayCollection();
        $this->openingHours = new ArrayCollection();
    }

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
     * Get Bookings
     *
     * @return ArrayCollection
     */
    public function getBookings()
    {
        return $this->bookings;
    }

    /**
     * Add Booking into Crenel
     *
     * @param \App\Entity\Booking $booking
     * @return Crenel
     */
    public function addBooking(Booking $booking)
    {
        $this->bookings[] = $booking;

        return $this;
    }

    /**
     * Remove Booking from Crenel
     *
     * @param \App\Entity\Booking $booking
     * @return Crenel
     */
    public function removeBooking(Booking $booking)
    {
        $this->bookings->removeElement($booking);

        return $this;
    }

    /**
     * Get OpeningHour
     *
     * @return ArrayCollection
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Add OpeningHour into Crenel
     *
     * @param \App\Entity\OpeningHour $openingHour
     * @return Crenel
     */
    public function addOpeningHour(OpeningHour $openingHour)
    {
        $this->openingHours[] = $openingHour;

        return $this;
    }

    /**
     * Remove OpeningHour from Crenel
     *
     * @param \App\Entity\OpeningHour $openingHour
     * @return Crenel
     */
    public function removeOpeningHour(OpeningHour $openingHour)
    {
        $this->openingHours->removeElement($openingHour);

        return $this;
    }
}
