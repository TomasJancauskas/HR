<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatalistType extends EntityType
{
    /**
     * DatalistType constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'datalist';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['suggestions']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['suggestions'] = $options['suggestions'];
    }
}