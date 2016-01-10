<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MenuBuilder extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     * @return \Knp\Menu\ItemInterface
     */
    public function top(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav pull-right');

        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            $menu->addChild($this->trans('employees'), ['route' => 'app_employee_index']);
            $menu->addChild($this->trans('vacations'), ['route' => 'app_vacation_index']);
            $menu->addChild($this->trans('locations'), ['route' => 'app_location_index']);
            // dropdown
            $dropdown = $menu->addChild($user, ['attributes' => [
                'role' => 'presentation',
                'dropdown' => true,
                'icon' => 'fa fa-user',
            ]]);
            // logout
            $dropdown->addChild($this->trans('logout'), ['route' => 'app_user_logout', 'attributes' => [
                'role' => 'presentation',
                'icon' => 'fa fa-sign-out',
            ]]);
        }

        if (!$user instanceof UserInterface) {
            // signin
            $menu->addChild($this->trans('login'), ['route' => 'app_user_login', 'attributes' => [
                'role' => 'presentation',
                'icon' => 'fa fa-sign-in',
            ]]);
        }

        return $menu;
    }

    /**
     * @return UserInterface
     */
    private function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        $token = $this->container->get('security.token_storage')->getToken();
        if (!$token instanceof TokenInterface) {
            return null;
        }

        return $token->getUser();
    }

    /**
     * @param string $label
     * @return string
     */
    private function trans($label)
    {
        return $this->container->get('translator')->trans($label, [], 'menu');
    }
}
