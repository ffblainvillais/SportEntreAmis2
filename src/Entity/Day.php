<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Crenel;

/**
 * @ORM\Entity
 * @ORM\Table(name="days")
 */
class Day
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
     * One Day has Many Crenel.
     * @ORM\OneToMany(targetEntity="App\Entity\Crenel", mappedBy="day")
     */
    private $crenels;

    /**
     * Many Ground have One Establishment.
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="days")
     * @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     */
    private $establishment;

    /**
     * Many OpeningHour have Many Hour.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Hour", mappedBy="day")
     */
    private $hours;

    public function __construct()
    {
        $this->crenels  = new ArrayCollection();
        $this->hours    = new ArrayCollection();
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
     * Get Hours
     *
     * @return ArrayCollection
     */
    function getHours()
    {
        return $this->hours;
    }

    /**
     * Add Crenel into Day
     *
     * @param \App\Entity\Hour $hour
     * @return Day
     */
    public function addCrenel(Hour $hour)
    {
        $this->hours[] = $hour;

        return $this;
    }

    /**
     * Remove Crenel from Day
     *
     * @param \App\Entity\Hour $hour
     * @return Day
     */
    public function removeCrenel(Hour $hour)
    {
        $this->hours->removeElement($hour);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    public function setEstablishment(Establishment $establishment)
    {
        $this->establishment = $establishment;
    }

    public  function __toString()
    {
        return $this->name;
    }

}
