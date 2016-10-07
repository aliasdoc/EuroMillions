<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicStatistics.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ArturAlves\EuroMillionsBundle\Entity\BasicStatisticsRepository")
 */
class BasicStatistics
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
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

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
     * Set total.
     *
     * @param int $total
     *
     * @return BasicStatistics
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
}
