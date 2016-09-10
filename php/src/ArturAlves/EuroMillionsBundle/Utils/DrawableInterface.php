<?php

namespace ArturAlves\EuroMillionsBundle\Utils;

interface DrawableInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set value
     *
     * @param integer $value
     * @return Number
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue();
}
