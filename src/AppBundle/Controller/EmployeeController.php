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
 * @Route("/employee")
 */
class EmployeeController extends Controller
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
        $employees = $this->repo('AppBundle:Employee')->createQueryBuilder('e')
            ->select('e', 'l', 'j', 'v')
            ->leftJoin('e.location', 'l')
            ->leftJoin('e.job', 'j')
            ->leftJoin('e.vacations', 'v');

        return [
            'employees' => new Pagination($employees, $request),
        ];
    }

    /**
     * Displays a form to create a new Employee entity.
     *
     * @Route("/new")
     * @Method("GET")
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        return [];
    }

    /**
     * Displays a form to create a new Employee entity.
     *
     * @Route("/new")
     * @Method("POST")
     * @Template
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxCreateAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(new EmployeeType($this->get('em')), $employee);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('AppBundle::ajax.html.twig',[
                'form' => $form->createView(),
                'path' => $this->generateUrl('app_employee_ajaxcreate'),
            ]);
        }

        $this->persist($employee);
        $this->flush();
        $this->addFlash("success", $this->get('translator')->trans('employee.flash.created'));

        return $this->render('AppBundle::ajax.html.twig',[
            'form' => $form->createView(),
            'path' => $this->generateUrl('app_employee_ajaxcreate'),
        ]);
    }


    /**
     * Displays a form to edit an existing Employee entity.
     *
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template
     *
     * @param Employee $employee
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Employee $employee, Request $request)
    {
        return [
            'employee' => $employee,
        ];
    }

    /**
     * Displays a form to edit an existing Employee entity.
     *
     * @Route("/{id}/edit")
     * @Method("POST")
     * @Template
     *
     * @param Employee $employee
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxEditAction(Employee $employee, Request $request)
    {
        $form = $this->createForm(new EmployeeType($this->get('em')), $employee);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('AppBundle::ajax.html.twig',[
                'form' => $form->createView(),
                'path' => $this->generateUrl('app_employee_ajaxedit', ['id' => $employee->getId()]),
            ]);
        }

        $this->persist($employee);
        $this->flush();
        $this->addFlash("success", $this->get('translator')->trans('employee.flash.updated'));

        return $this->render('AppBundle::ajax.html.twig',[
            'form' => $form->createView(),
            'path' => $this->generateUrl('app_employee_ajaxedit', ['id' => $employee->getId()]),
        ]);
    }

    /**
     * Deletes an Employee entity.
     *
     * @Route("/{id}/delete")
     * @Method("GET")
     *
     * @param Employee $employee
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Employee $employee)
    {
        $this->remove($employee);
        $this->flush();
        $this->addFlash("danger", $this->get('translator')->trans('employee.flash.removed'));

        return $this->redirectToRoute('app_employee_index');
    }
}
