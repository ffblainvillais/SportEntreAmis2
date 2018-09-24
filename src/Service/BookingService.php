<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class BookingService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    //public function
}