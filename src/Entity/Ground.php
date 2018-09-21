<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroundRepository")
 * @ORM\Table(name="grounds")
 */
class Ground
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * One Ground serves only one sport.
     * @ORM\ManyToOne(targetEntity="App\Entity\Sport")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     */
    private $sport;

    /**
     * Many Ground have One Establishment.
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment", inversedBy="grounds")
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
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param integer $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
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
     * @return mixed
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param mixed $sport
     */
    public function setSport(Sport $sport)
    {
        $this->sport = $sport;
    }

    /**
     * @return mixed
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    /**
     * @param mixed $establishment
     */
    public function setEstablishment(Establishment $establishment)
    {
        $this->establishment = $establishment;
    }

}
