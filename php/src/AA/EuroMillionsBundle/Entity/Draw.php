<?php

namespace AA\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use AA\EuroMillionsBundle\Helper\RulesHelper;

/**
 * Draw
 * @Assert\Callback(methods={"isDrawValid"})
 */
class Draw
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $result;

    /**
     * @var \DateTime
     * @Assert\Date()
     */
    private $date;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return Draw
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Draw
     */
    public function setDate($date)
    {
        if (!$date instanceof \DateTime) {
            $this->date = new \DateTime($date);
        } else {
            $this->date = $date;
        }

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function isDrawValid(ExecutionContextInterface $context)
    {
        $result = json_decode($this->getResult(), true);

        // Checks if the result array format is valid
        if (!isset($result['numbers']) || !isset($result['stars'])) {
            $context->addViolationAt(
                'result',
                'The result format is not valid',
                array(),
                null
            );
        }

        $rulesHelper = RulesHelper::getInstance();

        // Checks if the numbers count is valid
        if (count($result['numbers']) !== $rulesHelper->getNumbersCount()) {
            $context->addViolationAt(
                'result',
                'The numbers count is not valid',
                array(),
                null
            );
        }

        // Checks if the stars count is valid
        if (count($result['stars']) !== $rulesHelper->getStarsCount()) {
            $context->addViolationAt(
                'result',
                'The stars count is not valid',
                array(),
                null
            );
        }

        $date = date('D', strtotime($this->getDate()->format('Y-m-d')));
        $drawDays = array($rulesHelper->getRecurrency());

        // Checks if the date is valid
        if (!in_array($date, $drawDays)) {
            $context->addViolationAt(
                'result',
                'The date is not valid',
                array(),
                null
            );
        }
    }
}
