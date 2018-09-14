<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Establishment;
use App\Entity\Ground;
use App\Form\EstablishmentType;
use App\Form\GroundType;
use App\Service\GroundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    protected $groundService;

    public function __construct(GroundService $groundService)
    {
        $this->groundService = $groundService;
    }

    public function indexAction()
    {
        $establishment          = $this->getUser()->getEstablishment();
        $establishmentGrounds   = null;

        if ($establishment) {
            $establishmentGrounds   = $this->groundService->getGroundMappedBySportForEstablishment($establishment);
        }

        return $this->render('user/index.twig', [
            'userEstablishment' => $establishment,
            'groundsPerSport'   => $establishmentGrounds,
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
        $establishment  = $this->getUser()->getEstablishment();
        $days           = $this->getDoctrine()->getRepository(Day::class)->findAll();

        return $this->render(
            'user/opening-hours.twig',
            array(
                'establishment' => $establishment,
                'days'          => $days,
            )
        );
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
}