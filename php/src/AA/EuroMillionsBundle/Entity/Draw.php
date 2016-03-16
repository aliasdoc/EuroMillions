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
     * @var string
     */
    private $result;

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
