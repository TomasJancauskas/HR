<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Vacation;
use AppBundle\Form\VacationType;
use DataDog\PagerBundle\Pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/vacation")
 */
class VacationController extends Controller
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
        $vacations = $this->repo('AppBundle:Vacation')->createQueryBuilder('v');

        return [
            'vacations' => new Pagination($vacations, $request),
        ];
    }

    /**
     * Displays a form to create a new Vacation entity.
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
     * Displays a form to create a new Vacation entity.
     *
     * @Route("/new")
     * @Method("POST")
     * @Template
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $vacation = new Vacation();
        $form = $this->createForm(new VacationType(), $vacation);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('AppBundle::ajax.html.twig',[
                'form' => $form->createView(),
                'path' => $this->generateUrl('app_vacation_create'),
            ]);
        }

        $this->persist($vacation);
        $this->flush();
        $this->addFlash("success", $this->get('translator')->trans('vacation.flash.created'));

        return $this->render('AppBundle::ajax.html.twig',[
            'form' => $form->createView(),
            'path' => $this->generateUrl('app_vacation_create'),
        ]);
    }

    /**
     * Deletes an Vacation entity.
     *
     * @Route("/{id}/delete")
     * @Method("GET")
     *
     * @param Vacation $vacation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Vacation $vacation)
    {
        $this->remove($vacation);
        $this->flush();
        $this->addFlash("danger", $this->get('translator')->trans('employee.flash.removed'));

        return $this->redirectToRoute('app_vacation_index');
    }
}
