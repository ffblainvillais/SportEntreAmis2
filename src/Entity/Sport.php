<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 * @ORM\Table(name="sports")
 */
class Sport
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
    private $pictoPath;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $imagePath;

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
    public function getPictoPath()
    {
        return $this->pictoPath;
    }

    /**
     * @param string $pictoPath
     */
    public function setPictoPath($pictoPath)
    {
        $this->pictoPath = $pictoPath;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public  function __toString()
    {
        return $this->name;
    }
}
