<?php

namespace ArturAlves\EuroMillionsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Verifies if a Draw obeys the configured rules.
 *
 * @author Artur Alves <artur.alves@gatewit.com>
 */
class ObeysTheRulesValidator extends ConstraintValidator
{
    /**
     * The service container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The service container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Validates a Draw.
     *
     * @param Draw       $draw       The draw to be validated
     * @param Constraint $constraint The constraint
     */
    public function validate($draw, Constraint $constraint)
    {
        // Checks if the date is set
        if (is_null($draw->getDate())) {
            $this->context->addViolationAt(
                'date',
                'The date is not set'
            );

            return false;
        }

        // Gets the active rules
        $em = $this->container->get('doctrine')->getManager();
        $drawRulesRepository = $em->getRepository('ArturAlvesEuroMillionsBundle:DrawRules');
        $rules = $drawRulesRepository->getDrawRules($draw->getDate());

        $result = json_decode($draw->getResult(), true);

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
        $count = count($result['numbers']);
        for ($i = 0; $i < $count; ++$i) {
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
        $count = count($result['stars']);
        for ($i = 0; $i < $count; ++$i) {
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
        $drawDays = explode(',', $rules->getWeekDays());
        if (!in_array($draw->getDate()->format('D'), $drawDays)) {
            $this->context->addViolationAt(
                'date',
                'The date is not valid'
            );
        }
    }
}
