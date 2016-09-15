<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ArturAlves\EuroMillionsBundle\Utils\DrawableInterface;

/**
 * Number
 *
 * @ORM\Table(name="number")
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\NumberRepository")
 */
class Number implements DrawableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="frequency", type="integer")
     */
    private $frequency;

    /**
     * @var integer
     *
     * @ORM\Column(name="relative_frequency", type="float")
     */
    private $relative_frequency;

    /**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="float")
     */
    private $percentage;


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
     * Set value
     *
     * @param integer $value
     * @return Number
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set frequency
     *
     * @param integer $frequency
     * @return Number
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set relative_frequency
     *
     * @param float $relativeFrequency
     * @return Number
     */
    public function setRelativeFrequency($relativeFrequency)
    {
        $this->relative_frequency = $relativeFrequency;

        return $this;
    }

    /**
     * Get relative_frequency
     *
     * @return float
     */
    public function getRelativeFrequency()
    {
        return $this->relative_frequency;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     * @return Number
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float 
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
}
