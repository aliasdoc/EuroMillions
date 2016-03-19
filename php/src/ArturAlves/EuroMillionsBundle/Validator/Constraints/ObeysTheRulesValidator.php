<?php

namespace ArturAlves\EuroMillionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ArturAlves\EuroMillionsBundle\Model\Rules;

/**
 * Verifies if a Draw obeys the configured rules.
 */
class ObeysTheRulesValidator extends ConstraintValidator
{
    /**
     * The rules to validate the draw
     *
     * @var Rules
     */
    protected $rules;

    /**
     * Constructor
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  Rules $rules Necessary rules to validate the draw
     */
    public function __construct(Rules $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validates a Draw
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  Draw $draw The draw to be validated
     * @param  Constraint $constraint The constraint
     */
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

        // Checks if the numbers are in the range
        for ($i = 0; $i < count($result['numbers']); $i++) {
            if ($result['numbers'][$i] > $this->rules->getNumbersMaxLimit()
                || $result['numbers'][$i] < $this->rules->getNumbersMinLimit()
            ) {
                $this->context->addViolationAt(
                    'result',
                    'The numbers are not in the valid range',
                    array(),
                    null
                );
            }
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

        // Checks if the stars are in the range
        for ($i = 0; $i < count($result['stars']); $i++) {
            if ($result['stars'][$i] > $this->rules->getStarsMaxLimit()
                || $result['stars'][$i] < $this->rules->getStarsMinLimit()
            ) {
                $this->context->addViolationAt(
                    'result',
                    'The stars are not in the valid range',
                    array(),
                    null
                );
            }
        }

        // Checks if the date is valid
        $drawDays = explode(",", $this->rules->getRecurrency());
        if (is_null($draw->getDate()) || !in_array($draw->getDate()->format('D'), $drawDays)) {
            $this->context->addViolationAt(
                'date',
                'The date is not valid',
                array(),
                null
            );
        }
    }
}
