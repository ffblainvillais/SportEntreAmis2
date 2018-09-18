<?php

namespace App\Service;

use App\Entity\Department;
use App\Entity\Establishment;
use App\Entity\Sport;
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
        $postalCode         = $this->_getPostalCodeFromDepartmentInfo($department);
        $establishmentMatch = array();

        if ($postalCode) {

            $establishments     = $this->em->getRepository(Establishment::class)->getEstablishmentWithPostalCodeAndSport($postalCode, $sports);
            $establishmentMatch = array();

            foreach ($establishments as $establishment) {

                $establishmentMatch[] = $this->_getEstablishmentById($establishment['id']);
            }
        }

        return $establishmentMatch;
    }

    /**
     * Find Department from a name or a code and return his code
     *
     * @param string|integer $department
     * @return integer|null
     */
    private function _getPostalCodeFromDepartmentInfo($department)
    {
        if (is_numeric($department)) {

            $department = $this->em->getRepository(Department::class)->findOneBy(['code' => substr($department, 0, 2)]);

        } elseif (is_string($department)) {

            $department = $this->em->getRepository(Department::class)->findOneBy(['name' => ucfirst($department)]);
        }

        $postalCode = null;

        if ($department) {
            $postalCode = $department->getCode();
        }

        return $postalCode;
    }

    public function mapEstablishmentWithSports($establishments)
    {
        $establishmentsMapped = array();

        foreach ($establishments as $establishment) {

            $establishmentInfo = array(
                "establishment"     => $establishment,
                "sportsAvailable"   => $this->_getSportAvailableForEstablishment($establishment),
            );

            $establishmentsMapped[] = $establishmentInfo;
        }

        return $establishmentsMapped;
    }

    private function _getSportAvailableForEstablishment(Establishment $establishment)
    {
        $sportsAvailableIds = $this->em->getRepository(Establishment::class)->getSportAvailableForEstablishment($establishment);
        $sportsAvailable    = array();

        foreach ($sportsAvailableIds as $sportsAvailableId) {

            $sport              = $this->_getSportById($sportsAvailableId['id']);
            $sportsAvailable[]  = $sport;
        }

        return $sportsAvailable;
    }

    public function autocompleteDepartment($part)
    {
        $department = $this->em->getRepository(Department::class)->autocomplete($part);

        return $department;
    }

    public function cleanInputParam($param)
    {
        $param = filter_var(trim($param), FILTER_SANITIZE_STRING);

        return $param;
    }

    private function _getEstablishmentById($id)
    {
        return $this->em->getRepository(Establishment::class)->find($id);
    }

    private function _getSportById($id)
    {
        return $this->em->getRepository(Sport::class)->find($id);
    }

}