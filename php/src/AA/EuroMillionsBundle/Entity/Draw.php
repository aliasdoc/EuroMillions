<?php

namespace AA\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Draw
 */
class Draw
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $number1;

    /**
     * @var integer
     */
    private $number2;

    /**
     * @var integer
     */
    private $number3;

    /**
     * @var integer
     */
    private $number4;

    /**
     * @var integer
     */
    private $number5;

    /**
     * @var integer
     */
    private $star1;

    /**
     * @var integer
     */
    private $star2;

    /**
     * @var \DateTime
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
     * Set number1
     *
     * @param integer $number1
     * @return Draw
     */
    public function setNumber1($number1)
    {
        $this->number1 = $number1;

        return $this;
    }

    /**
     * Get number1
     *
     * @return integer
     */
    public function getNumber1()
    {
        return $this->number1;
    }

    /**
     * Set number2
     *
     * @param integer $number2
     * @return Draw
     */
    public function setNumber2($number2)
    {
        $this->number2 = $number2;

        return $this;
    }

    /**
     * Get number2
     *
     * @return integer
     */
    public function getNumber2()
    {
        return $this->number2;
    }

    /**
     * Set number3
     *
     * @param integer $number3
     * @return Draw
     */
    public function setNumber3($number3)
    {
        $this->number3 = $number3;

        return $this;
    }

    /**
     * Get number3
     *
     * @return integer
     */
    public function getNumber3()
    {
        return $this->number3;
    }

    /**
     * Set number4
     *
     * @param integer $number4
     * @return Draw
     */
    public function setNumber4($number4)
    {
        $this->number4 = $number4;

        return $this;
    }

    /**
     * Get number4
     *
     * @return integer
     */
    public function getNumber4()
    {
        return $this->number4;
    }

    /**
     * Set number5
     *
     * @param integer $number5
     * @return Draw
     */
    public function setNumber5($number5)
    {
        $this->number5 = $number5;

        return $this;
    }

    /**
     * Get number5
     *
     * @return integer
     */
    public function getNumber5()
    {
        return $this->number5;
    }

    /**
     * Set star1
     *
     * @param integer $star1
     * @return Draw
     */
    public function setStar1($star1)
    {
        $this->star1 = $star1;

        return $this;
    }

    /**
     * Get star1
     *
     * @return integer
     */
    public function getStar1()
    {
        return $this->star1;
    }

    /**
     * Set star2
     *
     * @param integer $star2
     * @return Draw
     */
    public function setStar2($star2)
    {
        $this->star2 = $star2;

        return $this;
    }

    /**
     * Get star2
     *
     * @return integer
     */
    public function getStar2()
    {
        return $this->star2;
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

    /**
     * Populates the entity with values from an array
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @param  array $data The values to populate the entity
     *
     * @return Draw The entity populated
     */
    public function fromArray($data)
    {
        if (!is_array($data)) {
            return null;
        }

        if (!is_array($data['numbers']) || !is_array($data['stars'])) {
            return null;
        }

        if (count($data['numbers']) != 5 || count($data['stars']) != 2) {
            return null;
        }

        $this->setNumber1($data['numbers'][0]);
        $this->setNumber2($data['numbers'][1]);
        $this->setNumber3($data['numbers'][2]);
        $this->setNumber4($data['numbers'][3]);
        $this->setNumber5($data['numbers'][4]);
        $this->setStar1($data['stars'][0]);
        $this->setStar2($data['stars'][1]);

        if (isset($data['date'])) {
            $this->setDate($data['date']);
        }

        return $this;
    }
}