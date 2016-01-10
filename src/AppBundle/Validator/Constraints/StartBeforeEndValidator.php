<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StartBeforeEndValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if ($object->getStartsAt() >= $object->getEndsAt()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('startsAt')
                ->addViolation();
            $this->context->buildViolation($constraint->message)
                ->atPath('endsAt')
                ->addViolation();
        }
    }
}