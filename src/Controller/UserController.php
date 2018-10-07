<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Establishment;
use App\Entity\Ground;
use App\Entity\Hour;
use App\Form\EstablishmentType;
use App\Form\GroundType;
use App\Service\CrenelService;
use App\Service\GroundService;
use App\Service\OpeningHourService;
use App\Service\ParameterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    protected $groundService;
    protected $crenelService;
    protected $parameterService;

    public function __construct(GroundService $groundService, CrenelService $crenelService, ParameterService $parameterService)
    {
        $this->groundService    = $groundService;
        $this->crenelService    = $crenelService;
        $this->parameterService = $parameterService;
    }

    public function indexAction()
    {
        $establishment          = $this->getUser()->getEstablishment();
        $establishmentGrounds   = null;
        $parameters             = null;

        if ($establishment) {
            $establishmentGrounds   = $this->groundService->getGroundMappedBySportForEstablishment($establishment);
            $parameters             = $this->parameterService->getEstablishmentParameters($establishment);
        }

        return $this->render('user/index.twig', [
            'userEstablishment'             => $establishment,
            'groundsPerSport'               => $establishmentGrounds,
            'establishementOpeningHours'    => $establishment ? $this->crenelService->getOpeningHoursToStringForEstablishment($establishment) : array(),
            'establishmentParameters'       => $parameters,
        ]);
    }

    public function establishmentAction(Request $request)
    {
        $user           = $this->getUser();
        $establishment  = $user->getEstablishment();

        if (!$establishment) {
            $establishment = new Establishment();
        }

        $establishmentForm  = $this->createForm(EstablishmentType::class, $establishment);

        $establishmentForm->handleRequest($request);

        if ($establishmentForm->isSubmitted() && $establishmentForm->isValid()) {

            $user->setEstablishment($establishment);
            $establishment->setHash(uniqid());

            $em = $this->getDoctrine()->getManager();
            $em->persist($establishment);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render(
            'user/establishment.twig',
            array('form' => $establishmentForm->createView())
        );
    }

    public function openingHoursAction()
    {
        $establishment                      = $this->getUser()->getEstablishment();

        //echo "<pre style='background:#fff; color:#000'>";\Doctrine\Common\Util\Debug::dump($establishment);die();
        //$hours                              = $this->getDoctrine()->getRepository(Hour::class)
        //$establishmentCrenelsMappedByDays   = $this->crenelService->getCrenelByHour($establishment, true);

        return $this->render(
            'user/opening-hours.twig',
            array(
                'establishment'                     => $establishment,
                //'establishmentCrenelsMappedByDays'  => $establishmentCrenelsMappedByDays,
                'openingHourPage'                   => true,
            )
        );
    }

    public function addOpeningHoursAction(Request $request)
    {
        $establishment  = $this->getUser()->getEstablishment();
        $crenelSelected = $request->request->get('selectedCrenelsMapped');

        $success        = $this->crenelService->addOpeningHours($crenelSelected, $establishment);

        if ($success) {
            $message = "Tout les créneaux ont bien été ajoutés";
        } else {
            $message = "Oups, un problème est survenu";
        }

        return $this->json($message);
    }

    public function groundAction(Request $request)
    {
        $establishment  = $this->getUser()->getEstablishment();

        $ground     = new Ground();
        $groundForm = $this->createForm(GroundType::class, $ground);

        $groundForm->handleRequest($request);

        if ($groundForm->isSubmitted() && $groundForm->isValid()) {

            $ground->setEstablishment($establishment);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ground);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render(
            'user/ground.twig',
            array('form' => $groundForm->createView())
        );
    }

    public function removeGroundAction(Request $request)
    {
        $groundId   = $request->attributes->get('groundId');
        $ground     = $this->getDoctrine()->getRepository(Ground::class)->find($groundId);

        $this->groundService->removeGround($ground);

        return $this->redirectToRoute('user');
    }
    
    public function majParamsAction(Request $request)
    {
        $parameters     = $request->request->get('parameters');
        $establishment  = $this->getUser()->getEstablishment();

        $this->parameterService->applyParameters($parameters, $establishment);

        return $this->redirectToRoute('user');
    }
}