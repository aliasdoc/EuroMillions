<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ArturAlves\EuroMillionsBundle\Utils\DrawableInterface;

/**
 * Star.
 *
 * @ORM\Table(name="star")
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\StarRepository")
 */
class Star implements DrawableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
    private $relative_frequency;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Star
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
     * @return Star
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
     * Set relative_frequency.
     *
     * @param float $relativeFrequency
     *
     * @return Star
     */
    public function setRelativeFrequency($relativeFrequency)
    {
        $this->relative_frequency = $relativeFrequency;

        return $this;
    }

    /**
     * Get relative_frequency.
     *
     * @return float
     */
    public function getRelativeFrequency()
    {
        return $this->relative_frequency;
    }

    /**
     * Set percentage.
     *
     * @param float $percentage
     *
     * @return Star
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
     * @return Star
     */
    public function setLastOccurrence($lastOccurrence)
    {
        if (!$lastOccurrence instanceof \DateTime) {
            $this->lastOccurrence = new \DateTime($lastOccurrence);
        } else {
            $this->lastOccurrence = $lastOccurrence;
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
