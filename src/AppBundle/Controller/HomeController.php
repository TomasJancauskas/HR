<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    use DoctrineController;

    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function homepageAction()
    {
        return $this->redirectToRoute('app_user_login');
    }
}
