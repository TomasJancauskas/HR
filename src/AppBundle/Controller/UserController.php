<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    use DoctrineController;

    /**
     * @Route("/login")
     * @Method("GET")
     * @Template
     */
    public function loginAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_employee_index');
        }
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error && $error->getMessageKey() === 'Invalid credentials.') {
            $error = $this->get('translator')->trans('user.login.incorrect_credentials');
        }
        return compact('lastUsername', 'error');
    }
}
