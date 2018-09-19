<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Crenel;

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
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type;

    /**
     * Many Booking are on only one Ground.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Ground")
     * @ORM\JoinColumn(name="ground_id", referencedColumnName="id")
     */
    private $ground;

    /**
     * Many Booking have Many Crenel.
     *
     * @ManyToMany(targetEntity="App\Entity\Crenel", inversedBy="bookings")
     * @JoinTable(name="bookings_crenels")
     */
    private $crenels;

    public function __construct()
    {
        $this->crenels = new ArrayCollection();
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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

    /**
     * Get Crenels
     *
     * @return ArrayCollection
     */
    function getCrenels()
    {
        return $this->crenels;
    }

    /**
     * Add Crenel into Day
     *
     * @param \App\Entity\Crenel $crenel
     * @return Day
     */
    public function addCrenel(Crenel $crenel)
    {
        $this->crenels[] = $crenel;

        return $this;
    }

    /**
     * Remove Crenel from Day
     *
     * @param \App\Entity\Crenel $crenel
     * @return Day
     */
    public function removeCrenel(Crenel $crenel)
    {
        $this->crenels->removeElement($crenel);

        return $this;
    }
}
