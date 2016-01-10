<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AfterJoinDateValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        if ($object->getEmployee()->getJoinedAt() > $object->getStartsAt()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('startsAt')
                ->addViolation();
        }
    }
}