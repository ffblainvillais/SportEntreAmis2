<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    public function indexAction()
    {
        return $this->render('user/index.twig', [
            'userEstablishment' => null
        ]);
    }

}