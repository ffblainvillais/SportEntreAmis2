<?php

namespace App\Service;

use App\Entity\Establishment;
use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;

class ParameterService
{
    protected $em;
    protected $defaultParametersValues = array(
        self::PARAM_AUTO_CONFIRM            => false,
        self::PARAM_SEND_RESERVATION_MAIL   => true,
    );

    const PARAM_AUTO_CONFIRM            = "auto-confirm";
    const PARAM_SEND_RESERVATION_MAIL   = "send-mail-reservation";

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Remove all Parameter and apply new values
     *
     * @param array $params
     * @param Establishment $establishment
     */
    public function applyParameters($params, Establishment $establishment)
    {
        $this->_removeOldParameters($establishment);

        foreach ($params as $name => $value) {

            $parameter  = $this->em->getRepository(Parameter::class)->findOneBy(['name' => $name, 'value' => $value]);

            if ($parameter) {

                $establishment->addParameter($parameter);
                $this->em->persist($establishment);
            }
        }

        $this->em->flush();
    }

    /**
     * Return Establishment Parameter, if don't have set it defaults Parameters
     *
     * @param Establishment $establishment
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEstablishmentParameters(Establishment $establishment)
    {
        $establishmentParameters = $establishment->getParameters();

        if ($establishmentParameters->isEmpty()) {

            $this->_initializeEstablishmentParameters($establishment);

            $this->em->refresh($establishment);

            $establishmentParameters = $establishment->getParameters();
        }

        return $establishmentParameters;
    }

    /**
     * Set default Parameter to Establishment
     *
     * @param Establishment $establishment
     */
    private function _initializeEstablishmentParameters(Establishment $establishment)
    {
        $defaultsParameters         = $this->_getDefaultParameters();

        foreach ($defaultsParameters as $defaultParameter) {

            $establishment->addParameter($defaultParameter);
            $this->em->merge($establishment);
        }

        $this->em->flush();
    }

    /**
     * Return default Parameter list
     *
     * @return array
     */
    private function _getDefaultParameters()
    {
        $defaultParameters = array();

        foreach ($this->defaultParametersValues as $name => $value) {

            $defaultParameter = $this->em->getRepository(Parameter::class)->findOneBy(['name' => $name, 'value' => $value]);

            if ($defaultParameter) {
                $defaultParameters[] = $defaultParameter;
            }
        }

        return $defaultParameters;
    }

    /**
     * Remove all Parameter from Establishment
     *
     * @param Establishment $establishment
     */
    private function _removeOldParameters(Establishment $establishment)
    {
        $parameters = $establishment->getParameters();

        if (!empty($parameters)) {

            foreach ($parameters as $parameter) {

                $establishment->removeParameter($parameter);
            }
        }

        $this->em->persist($establishment);
        $this->em->flush();
    }

}