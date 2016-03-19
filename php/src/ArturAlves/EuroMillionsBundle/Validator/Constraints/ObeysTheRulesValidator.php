<?php

namespace ArturAlves\EuroMillionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ArturAlves\EuroMillionsBundle\Model\Rules;

class ObeysTheRulesValidator extends ConstraintValidator
{
    protected $rules;

    public function __construct(Rules $rules)
    {
        $this->rules = $rules;
    }

    public function validate($draw, Constraint $constraint)
    {
        $result = json_decode($draw->getResult(), true);

        // Checks if the result array format is valid
        if (!isset($result['numbers']) || !isset($result['stars'])) {
            $this->context->addViolationAt(
                'result',
                'The result format is not valid',
                array(),
                null
            );
        }

        // Checks if the numbers count is valid
        if (count($result['numbers']) !== $this->rules->getNumbersCount()) {
            $this->context->addViolationAt(
                'result',
                'The numbers count is not valid',
                array(),
                null
            );
        }

        // Checks if the stars count is valid
        if (count($result['stars']) !== $this->rules->getStarsCount()) {
            $this->context->addViolationAt(
                'result',
                'The stars count is not valid',
                array(),
                null
            );
        }

        // Checks if the date is valid
        $drawDays = array($this->rules->getRecurrency());
        if (
            is_null($draw->getDate())
            || !in_array($draw->getDate()->format('D'), $drawDays)
        ) {
            $this->context->addViolationAt(
                'result',
                'The date is not valid',
                array(),
                null
            );
        }
    }
}
