<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Number.
 *
 * @ORM\Table(name="number")
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\NumberRepository")
 */
class Number
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $identifier;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="frequency", type="integer")
     */
    private $frequency;

    /**
     * @var int
     *
     * @ORM\Column(name="relative_frequency", type="float")
     */
    private $relativeFrequency;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="float")
     */
    private $percentage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_occurrence", type="date", nullable=true)
     */
    private $lastOccurrence;

    /**
     * Get $identifier.
     *
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Number
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set frequency.
     *
     * @param int $frequency
     *
     * @return Number
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency.
     *
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set relativeFrequency.
     *
     * @param float $relativeFrequency
     *
     * @return Number
     */
    public function setRelativeFrequency($relativeFrequency)
    {
        $this->relativeFrequency = $relativeFrequency;

        return $this;
    }

    /**
     * Get relativeFrequency.
     *
     * @return float
     */
    public function getRelativeFrequency()
    {
        return $this->relativeFrequency;
    }

    /**
     * Set percentage.
     *
     * @param float $percentage
     *
     * @return Number
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage.
     *
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set lastOccurrence.
     *
     * @param \DateTime $lastOccurrence
     *
     * @return Number
     */
    public function setLastOccurrence($lastOccurrence)
    {
        $this->lastOccurrence = $lastOccurrence;
        if (!$lastOccurrence instanceof \DateTime) {
            $this->lastOccurrence = new \DateTime($lastOccurrence);
        }

        return $this;
    }

    /**
     * Get lastOccurrence.
     *
     * @return \DateTime
     */
    public function getLastOccurrence()
    {
        return $this->lastOccurrence;
    }
}
