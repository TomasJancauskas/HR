<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DoesNotOverlap extends Constraint
{
    public $message = 'validators.overlap';

    public function validatedBy()
    {
        return 'does_not_overlap_validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}