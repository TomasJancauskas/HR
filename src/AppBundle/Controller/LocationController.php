<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Form\EmployeeType;
use DataDog\PagerBundle\Pagination;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/location")
 */
class LocationController extends Controller
{
    use DoctrineController;

    /**
     * @Route("/")
     * @Method("GET")
     * @Template
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $locations = $this->repo('AppBundle:Location')->createQueryBuilder('l')
            ->select('l', 'e')
            ->leftJoin('l.employees', 'e');

        return [
            'locations' => new Pagination($locations, $request),
        ];
    }
}
