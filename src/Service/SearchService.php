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

    /**
     * Search Establishment process
     *
     * @param string $department
     * @param null|array $sports
     * @return array
     */
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

    /**
     * Prepare rendering Establishment and Sport for view
     *
     * @param array $establishments
     * @return array
     */
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

    /**
     * Return all Sport available in Establishment
     *
     * @param Establishment $establishment
     * @return array
     */
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

    /**
     * Autocomplete department with input
     *
     * @param string $part
     * @return mixed
     */
    public function autocompleteDepartment($part)
    {
        $department = $this->em->getRepository(Department::class)->autocomplete($part);

        return $department;
    }

    /**
     * Prevent Xss with cleaning input
     *
     * @param string $param
     * @return mixed
     */
    public function cleanInputParam($param)
    {
        $param = filter_var(trim($param), FILTER_SANITIZE_STRING);

        return $param;
    }

    /**
     * Return Establishment by id
     *
     * @param integer $id
     * @return null|object
     */
    private function _getEstablishmentById($id)
    {
        return $this->em->getRepository(Establishment::class)->find($id);
    }

    /**
     * Return Sport by id
     *
     * @param integer $id
     * @return null|object
     */
    private function _getSportById($id)
    {
        return $this->em->getRepository(Sport::class)->find($id);
    }

}