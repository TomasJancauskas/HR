<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use AppBundle\Form\DataTransformer\JobToTextTransformer;
use AppBundle\Form\DataTransformer\LocationToTextTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * EmployeeType constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', [
                'label' => 'employee.label.firstname',
            ])
            ->add('lastname', 'text', [
                'label' => 'employee.label.lastname',
            ])
            ->add('job', 'datalist', [
                'suggestions' => $this->em->getRepository('AppBundle:Job')->findAll(),
                'label' => 'employee.label.job',
            ])
            ->add('location', 'datalist', [
                'suggestions' => $this->em->getRepository('AppBundle:Location')->findAll(),
                'label' => 'employee.label.location',
            ])
            ->add('birthdate', 'date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'employee.label.birthdate',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('joinedAt', 'date', [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'employee.label.joined',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ]);

        $builder->get('location')->resetViewTransformers();
        $builder->get('location')
            ->addModelTransformer((new LocationToTextTransformer($this->em)));

        $builder->get('job')->resetViewTransformers();
        $builder->get('job')
            ->addModelTransformer((new JobToTextTransformer($this->em)));
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'employee';
    }
}
