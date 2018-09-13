<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Entity\Ground;
use App\Form\EstablishmentType;
use App\Form\GroundType;
use App\Service\GroundService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    public function indexAction(GroundService $groundService)
    {
        $user           = $this->getUser();
        $establishment  = $this->getDoctrine()
            ->getRepository(Establishment::class)
            ->getEstablishementOfUser($user);

        return $this->render('user/index.twig', [
            'userEstablishment' => $establishment,
            'groundsPerSport'   => $groundService->getGroundMappedBySportForEstablishment($establishment),
        ]);
    }

    public function establishmentAction(Request $request)
    {
        $user           = $this->getUser();
        $establishment  = $this->getDoctrine()->getRepository(Establishment::class)->getEstablishementOfUser($user);

        if (!$establishment) {
            $establishment = new Establishment();
        }

        $establishmentForm  = $this->createForm(EstablishmentType::class, $establishment);

        $establishmentForm->handleRequest($request);

        if ($establishmentForm->isSubmitted() && $establishmentForm->isValid()) {

            $establishment->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($establishment);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render(
            'user/establishment.twig',
            array('form' => $establishmentForm->createView())
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
}