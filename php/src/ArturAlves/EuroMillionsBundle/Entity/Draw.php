<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ArturAlves\EuroMillionsBundle\Validator\Constraints as RulesAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Draw.
 *
 * @ORM\Table(name="draw")
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\DrawRepository")
 *
 * @RulesAssert\ObeysTheRules
 */
class Draw
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     *
     * @Assert\Date()
     */
    private $date;

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
     * Set id.
     *
     * @param string $id
     *
     * @return Draw
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set result.
     *
     * @param string $result
     *
     * @return Draw
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result.
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
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
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get draw's numbers.
     *
     * @return ArrayCollection|null
     */
    public function getNumbers()
    {
        $resultArray = json_decode($this->getResult(), true);
        if (!isset($resultArray['numbers'])) {
            return null;
        }

        $numbers = $resultArray['numbers'];
        $collection = new ArrayCollection();
        foreach ($numbers as $value) {
            $number = new Number();
            $number->setValue($value);
            $collection->add($number);
        }

        return $collection;
    }

    /**
     * Get draw's stars.
     *
     * @return ArrayCollection|null
     */
    public function getStars()
    {
        $resultArray = json_decode($this->getResult(), true);
        if (!isset($resultArray['stars'])) {
            return null;
        }

        $stars = $resultArray['stars'];
        $collection = new ArrayCollection();
        foreach ($stars as $value) {
            $star = new Star();
            $star->setValue($value);
            $collection->add($star);
        }

        return $collection;
    }
}
