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
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Crenel", mappedBy="day")
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

    public  function __toString()
    {
        return $this->name;
    }
}
