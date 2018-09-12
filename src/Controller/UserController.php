<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Form\EstablishmentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    public function indexAction()
    {
        $user           = $this->getUser();
        $establishment  = $this->getDoctrine()
            ->getRepository(Establishment::class)
            ->getEstablishementOfUser($user);

        return $this->render('user/index.twig', [
            'userEstablishment' => $establishment
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
}