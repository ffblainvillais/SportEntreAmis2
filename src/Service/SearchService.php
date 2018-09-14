<?php

namespace App\Service;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function searchEstablishment($department, $sports = null)
    {
        $establishments = $this->em->getRepository(Establishment::class)->getEstablishmentWithPostalCodeAndSport($department);
        
        echo "<pre style='background:#fff; color:#000'>";\Doctrine\Common\Util\Debug::dump($establishments);die();
    }

}