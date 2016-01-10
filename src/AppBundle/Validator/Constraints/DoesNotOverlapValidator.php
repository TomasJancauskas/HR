<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DoesNotOverlapValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * EnoughRemainingValidator constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint)
    {
        $qb = $this->em->getRepository('AppBundle:Vacation')->createQueryBuilder('v');

        $overlaps = $qb
            ->where('v.employee = :employee')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->between('v.startsAt', ':startsAt', ':endsAt'),
                $qb->expr()->between('v.endsAt', ':startsAt', ':endsAt')
            ))
            ->setParameters([
                'employee' => $object->getEmployee(),
                'startsAt' => $object->getStartsAt(),
                'endsAt' => $object->getEndsAt(),
            ])
            ->getQuery()
            ->getResult();
        if ($overlaps) {
            $this->context->buildViolation($constraint->message)
                ->atPath('employee')
                ->addViolation();
        }
    }
}