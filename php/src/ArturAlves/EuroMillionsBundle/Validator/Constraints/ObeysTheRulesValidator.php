<?php

namespace ArturAlves\EuroMillionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Verifies if a Draw obeys the configured rules.
 */
class ObeysTheRulesValidator extends ConstraintValidator
{
    /**
     * The service container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  ContainerInterface $container The service container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

        // Gets the active rules
        $em = $this->container->get('doctrine')->getManager();
        $drawRulesRepository = $em->getRepository('ArturAlvesEuroMillionsBundle:DrawRules');
        $rules = $drawRulesRepository->getActiveDrawRules();

        // Checks if the result array format is valid
        if (!isset($result['numbers']) || !isset($result['stars'])) {
            $this->context->addViolationAt(
                'result',
                'The result format is not valid'
            );
        }

        // Checks if the numbers count is valid
        if (count($result['numbers']) !== $rules->getNumberCount()) {
            $this->context->addViolationAt(
                'result',
                'The numbers count is not valid'
            );
        }

        // Checks if the numbers are in the range
        for ($i = 0; $i < count($result['numbers']); $i++) {
            if ($result['numbers'][$i] > $rules->getNumberMaxValue()
                || $result['numbers'][$i] < $rules->getNumberMinValue()
            ) {
                $this->context->addViolationAt(
                    'result',
                    'The numbers are not in the valid range'
                );
            }
        }

        // Checks if the stars count is valid
        if (count($result['stars']) !== $rules->getStarCount()) {
            $this->context->addViolationAt(
                'result',
                'The stars count is not valid'
            );
        }

        // Checks if the stars are in the range
        for ($i = 0; $i < count($result['stars']); $i++) {
            if ($result['stars'][$i] > $rules->getStarMaxValue()
                || $result['stars'][$i] < $rules->getStarMinValue()
            ) {
                $this->context->addViolationAt(
                    'result',
                    'The stars are not in the valid range'
                );
            }
        }

        // Checks if the date is valid
        $drawDays = explode(",", $rules->getWeekDays());
        if (is_null($draw->getDate()) || !in_array($draw->getDate()->format('D'), $drawDays)) {
            $this->context->addViolationAt(
                'date',
                'The date is not valid'
            );
        }
    }
}
