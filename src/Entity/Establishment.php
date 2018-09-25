<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstablishmentRepository")
 * @ORM\Table(name="establishments")
 */
class Establishment
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
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $hash;

    /**
     * One Establishment has One User.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="establishment")
     */
    private $user;

    /**
     * One Establishment has Many Ground.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Ground", mappedBy="establishment")
     */
    private $grounds;

    /**
     * One Establishment has Many OpeningHours.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OpeningHour", mappedBy="establishment")
     */
    private $openingHours;

    /**
     * Many Establishment have Many Parameter.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Parameter")
     * @ORM\JoinTable(name="establishments__parameters",
     *   joinColumns={
     *     @ORM\JoinColumn(name="establishment_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="parameter_id", referencedColumnName="id")
     *   }
     * )
     */
    private $parameters;


    public function __construct()
    {
        $this->grounds      = new ArrayCollection();
        $this->openingHours = new ArrayCollection();
        $this->parameters   = new ArrayCollection();
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get Grounds
     *
     * @return ArrayCollection
     */
    function getGrounds()
    {
        return $this->grounds;
    }

    /**
     * Add Ground into Establishment
     *
     * @param \App\Entity\Ground $ground
     * @return Establishment
     */
    public function addGround(Ground $ground)
    {
        $this->grounds[] = $ground;

        return $this;
    }

    /**
     * Remove Ground from Establishment
     *
     * @param \App\Entity\Ground $ground
     * @return Establishment
     */
    public function removeGround(Ground $ground)
    {
        $this->grounds->removeElement($ground);

        return $this;
    }

    /**
     * Get Grounds
     *
     * @return ArrayCollection
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Add OpeningHour into Establishment
     *
     * @param \App\Entity\OpeningHour $openingHour
     * @return Establishment
     */
    public function addOpeningHour(OpeningHour $openingHour)
    {
        $this->openingHours[] = $openingHour;

        return $this;
    }

    /**
     * Remove OpeningHour from Establishment
     *
     * @param \App\Entity\OpeningHour $openingHour
     * @return Establishment
     */
    public function removeOpeningHour(OpeningHour $openingHour)
    {
        $this->openingHours->removeElement($openingHour);

        return $this;
    }

    /**
     * Get Parameters
     *
     * @return ArrayCollection
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Add Parameter into Establishment
     *
     * @param \App\Entity\Parameter $parameter
     * @return Establishment
     */
    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * Remove Parameter from Establishment
     *
     * @param \App\Entity\Parameter $parameter
     * @return Establishment
     */
    public function removeParameter(Parameter $parameter)
    {
        $this->parameters->removeElement($parameter);

        return $this;
    }
}
