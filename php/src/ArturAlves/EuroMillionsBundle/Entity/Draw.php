<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use ArturAlves\EuroMillionsBundle\Validator\Constraints as RulesAssert;

/**
 * Draw
 * @RulesAssert\ObeysTheRules
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
        
    }
}
