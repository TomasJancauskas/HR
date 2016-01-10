<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Entity\Vacation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class VacationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employee', 'entity', [
                'class' => Employee::class,
                'choice_label' => 'fullname',
                'label' => 'vacation.label.employee',
            ])
            ->add('startsAt', 'date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'vacation.label.startsAt',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('endsAt', 'date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'vacation.label.endsAt',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vacation::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vacation';
    }
}
