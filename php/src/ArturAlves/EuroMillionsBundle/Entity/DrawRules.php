<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DrawRules
 *
 * @ORM\Table(name="draw_rules")
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\DrawRulesRepository")
 */
class DrawRules
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_count", type="integer", nullable=false)
     */
    private $number_count;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_min_value", type="integer", nullable=false)
     */
    private $number_min_value;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_max_value", type="integer", nullable=false)
     */
    private $number_max_value;

    /**
     * @var integer
     *
     * @ORM\Column(name="star_count", type="integer", nullable=false)
     */
    private $star_count;

    /**
     * @var integer
     *
     * @ORM\Column(name="star_min_value", type="integer", nullable=false)
     */
    private $star_min_value;

    /**
     * @var integer
     *
     * @ORM\Column(name="star_max_value", type="integer", nullable=false)
     */
    private $star_max_value;

    /**
     * @var string
     *
     * @ORM\Column(name="week_days", type="string", length=30, nullable=false)
     */
    private $week_days;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $is_active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active_since", type="date", nullable=false)
     */
    private $active_since;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active_until", type="date", nullable=true)
     */
    private $active_until;


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
     * Set number_count
     *
     * @param integer $numberCount
     * @return DrawRules
     */
    public function setNumberCount($numberCount)
    {
        $this->number_count = $numberCount;

        return $this;
    }

    /**
     * Get number_count
     *
     * @return integer
     */
    public function getNumberCount()
    {
        return $this->number_count;
    }

    /**
     * Set number_min_value
     *
     * @param integer $numberMinValue
     * @return DrawRules
     */
    public function setNumberMinValue($numberMinValue)
    {
        $this->number_min_value = $numberMinValue;

        return $this;
    }

    /**
     * Get number_min_value
     *
     * @return integer
     */
    public function getNumberMinValue()
    {
        return $this->number_min_value;
    }

    /**
     * Set number_max_value
     *
     * @param integer $numberMaxValue
     * @return DrawRules
     */
    public function setNumberMaxValue($numberMaxValue)
    {
        $this->number_max_value = $numberMaxValue;

        return $this;
    }

    /**
     * Get number_max_value
     *
     * @return integer
     */
    public function getNumberMaxValue()
    {
        return $this->number_max_value;
    }

    /**
     * Set star_count
     *
     * @param integer $starCount
     * @return DrawRules
     */
    public function setStarCount($starCount)
    {
        $this->star_count = $starCount;

        return $this;
    }

    /**
     * Get star_count
     *
     * @return integer
     */
    public function getStarCount()
    {
        return $this->star_count;
    }

    /**
     * Set star_min_value
     *
     * @param integer $starMinValue
     * @return DrawRules
     */
    public function setStarMinValue($starMinValue)
    {
        $this->star_min_value = $starMinValue;

        return $this;
    }

    /**
     * Get star_min_value
     *
     * @return integer
     */
    public function getStarMinValue()
    {
        return $this->star_min_value;
    }

    /**
     * Set star_max_value
     *
     * @param integer $starMaxValue
     * @return DrawRules
     */
    public function setStarMaxValue($starMaxValue)
    {
        $this->star_max_value = $starMaxValue;

        return $this;
    }

    /**
     * Get star_max_value
     *
     * @return integer
     */
    public function getStarMaxValue()
    {
        return $this->star_max_value;
    }

    /**
     * Set week_days
     *
     * @param \DateTime $weekDays
     * @return DrawRules
     */
    public function setWeekDays($weekDays)
    {
        $this->week_days = $weekDays;

        return $this;
    }

    /**
     * Get week_days
     *
     * @return \DateTime
     */
    public function getWeekDays()
    {
        return $this->week_days;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return DrawRules
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set active_since
     *
     * @param \DateTime $activeSince
     * @return DrawRules
     */
    public function setActiveSince($activeSince)
    {
        $this->active_since = $activeSince;

        return $this;
    }

    /**
     * Get active_since
     *
     * @return \DateTime
     */
    public function getActiveSince()
    {
        return $this->active_since;
    }

    /**
     * Set active_until
     *
     * @param \DateTime $activeUntil
     * @return DrawRules
     */
    public function setActiveUntil($activeUntil)
    {
        $this->active_until = $activeUntil;

        return $this;
    }

    /**
     * Get active_until
     *
     * @return \DateTime
     */
    public function getActiveUntil()
    {
        return $this->active_until;
    }
}
