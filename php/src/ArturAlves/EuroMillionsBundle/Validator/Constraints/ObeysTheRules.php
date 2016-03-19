<?php

namespace ArturAlves\EuroMillionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ObeysTheRules extends Constraint
{
    public $message = 'This draw is invalid';

    public function validatedBy()
    {
        return 'ObeysTheRulesValidator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
