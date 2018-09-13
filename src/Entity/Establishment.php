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
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $openingHours;

    /**
     * One Establishment has One User.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="establishment")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * One Establishment has Many Ground.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Ground", mappedBy="establishment")
     */
    private $grounds;


    public function __construct()
    {
        $this->grounds = new ArrayCollection();
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
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * @param string $openingHours
     */
    public function setOpeningHours($openingHours)
    {
        $this->openingHours = $openingHours;
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
    public function addGroup(Ground $ground)
    {
        $this->grounds[] = $ground;

        return $this;
    }

    /**
     * Remove Ground from Establishment
     * @param \App\Entity\Ground $ground
     * @return Establishment
     */
    public function removeGroup(Ground $ground)
    {
        $this->grounds->removeElement($ground);

        return $this;
    }

}
