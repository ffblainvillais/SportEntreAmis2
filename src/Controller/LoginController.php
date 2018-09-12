<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    public function loginAction(AuthenticationUtils $helper)
    {
        return $this->render('register/login.twig', [
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
        ]);
    }

    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }

}