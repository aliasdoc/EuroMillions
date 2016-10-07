<?php

namespace ArturAlves\EuroMillionsBundle\Utils;

interface DrawableInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return Number
     */
    public function setValue($value);

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue();
}
