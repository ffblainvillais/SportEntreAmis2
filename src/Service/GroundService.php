<?php

namespace App\Service;

use App\Entity\Establishment;
use App\Entity\Ground;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;

class GroundService
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * get Ground information for view rendering
     *
     * @param Establishment $establishment
     * @return array
     */
    public function getGroundMappedBySportForEstablishment(Establishment $establishment)
    {
        $GroundsBySports    = array();
        $sports             = $this->em->getRepository(Sport::class)->findAll();

        foreach ($sports as $sport) {

            $gounds = $this->em->getRepository(Ground::class)->findBy(['sport' => $sport, 'establishment' => $establishment]);

            if (!empty($gounds)) {
                $GroundsBySports[$sport->getName()] = $gounds;
            }
        }

        return $GroundsBySports;
    }

    /**
     * Remove Ground
     *
     * @param Ground $ground
     */
    public function removeGround(Ground $ground)
    {
        $this->em->remove($ground);
        $this->em->flush();
    }


}