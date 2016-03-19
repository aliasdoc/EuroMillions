<?php

namespace ArturAlves\EuroMillionsBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Delivers the configured rules to the application
 *
 * @author Artur Alves <artur.alves@gatewit.com>
 */
class Rules
{
    /**
     * The rules configuration
     *
     * @var array
     */
    private $drawRules;

    /**
     * Constructor
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  Container $container The service container
     */
    public function __construct(Container $container)
    {
        $rules = $container->getParameter('artur_alves_euro_millions.rules');
        $this->drawRules = $rules['draw'];
    }

    /**
     * Returns the total amount of numbers in a draw
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The numbers count
     */
    public function getNumbersCount()
    {
        return $this->drawRules['numbers']['count'];
    }

    /**
     * Returns the smallest acceptable number
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The minimum number
     */
    public function getNumbersMinLimit()
    {
        return $this->drawRules['numbers']['range']['min'];
    }

    /**
     * Returns the biggest acceptable number
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The maximum number
     */
    public function getNumbersMaxLimit()
    {
        return $this->drawRules['numbers']['range']['max'];
    }

    /**
     * Returns the total amount of stars in a draw
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The stars count
     */
    public function getStarsCount()
    {
        return $this->drawRules['stars']['count'];
    }

    /**
     * Returns the smallest acceptable star
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The minimum star
     */
    public function getStarsMinLimit()
    {
        return $this->drawRules['stars']['range']['min'];
    }

    /**
     * Returns the biggest acceptable star
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return int The maximum star
     */
    public function getStarsMaxLimit()
    {
        return $this->drawRules['stars']['range']['max'];
    }

    /**
     * Returns the draw's recurrency value
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return string The draw's recurrency value
     */
    public function getRecurrency()
    {
        return $this->drawRules['recurrency']['value'];
    }

    /**
     * Returns the draw's recurrency type
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return string The draw's recurrency type
     */
    public function getRecurrencyType()
    {
        $validTypes = array("daily", "weekly", "monthly");
        $type = $this->drawRules['recurrency']['type'];
        if (!in_array($type, $validTypes)) {
            throw new Exception("The parameter 'rules_draw_recurrency_type' is not a valid type");
        }
        return $type;
    }
}
