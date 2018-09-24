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
     * Many OpeningHour have One Establishment.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="openingHours")
     * @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     */
    private $establishment;

    /**
     * Many OpeningHour have Many Crenel.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Crenel", inversedBy="openingHours")
     * @ORM\JoinTable(name="opening_hours__crenels")
     */
    private $crenels;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * Add Crenel into OpeningHour
     *
     * @param \App\Entity\Crenel $crenel
     * @return OpeningHour
     */
    public function addCrenel(Crenel $crenel)
    {
        $this->crenels[] = $crenel;

        return $this;
    }

    /**
     * Remove Crenel from OpeningHour
     *
     * @param \App\Entity\Crenel $crenel
     * @return OpeningHour
     */
    public function removeCrenel(Crenel $crenel)
    {
        $this->crenels->removeElement($crenel);

        return $this;
    }

    /**
     * Get OpeningHour Crenel for a Day
     *
     * @param Day $day
     * @return array
     */
    public function getCrenelsForDay(Day $day)
    {
        $crenels        = $this->getCrenels();
        $crenelsOfDay   = array();

        if ($crenels) {

            foreach ($crenels as $crenel) {

                if ($crenel->getDay() == $day) {
                    $crenelsOfDay[] = $crenel;
                }
            }
        }

        return $crenelsOfDay;
    }
}
