<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EnoughRemainingValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        $requested = (int) $object->getStartsAt()->diff($object->getEndsAt())->format('%d');
        if ($requested > $object->getEmployee()->getRemainingVacationdays()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('employee')
                ->addViolation();
        }
    }
}