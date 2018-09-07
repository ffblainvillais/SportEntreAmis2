<?php

namespace App\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    public function indexAction()
    {
        return $this->render('@User/user/index.twig', [
            'userEstablishment' => null
        ]);
    }

}