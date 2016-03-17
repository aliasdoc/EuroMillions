<?php

namespace AA\EuroMillionsBundle\Helper;

// use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

// http://stackoverflow.com/a/12057057/1687176
class RulesHelper
{
    private static $instance;
    // private $container;
    private $rules;

    public static function getInstance($container)
    {
        if (null === self::$instance) {
            // self::$instance = new self($container);
            self::$instance = new self();

            self::$instance->rules = $container->getParameter('aa_EuroMillions');
            if(!self::$instance->isValid()) {
                throw new Exception("The parameter 'aa_EuroMillions' is not properly configured");
            }
        }

        return self::$instance;
    }

    // public function __construct(Container $container)
    protected function __construct()
    {
        // $this->container = $container;
    }

    public function getNumbersCount()
    {
        if (!is_int($this->rules['rules']['draw']['numbers'])) {
            throw new Exception("The parameter 'aa_EuroMillions_rules_draw_numbers' is not a valid integer");
        }
        return $this->rules['rules']['draw']['numbers'];
    }

    public function getRecurrency()
    {
        return $this->rules['rules']['draw']['recurrency']['value'];
    }

    public function getRecurrencyType()
    {
        $validTypes = array("daily", "weekly", "monthly");
        $type = $this->rules['rules']['draw']['recurrency']['type'];
        if(!in_array($type, $validTypes)) {
            throw new Exception("The parameter 'aa_EuroMillions_rules_draw_recurrency_type' is not a valid type");
        }
        return $type;
    }

    public function getStarsCount()
    {
        if (!is_int($this->rules['rules']['draw']['stars'])) {
            throw new Exception("The parameter 'aa_EuroMillions_rules_draw_stars' is not a valid integer");
        }
        return (int) $this->rules['rules']['draw']['stars'];
    }

    private function isValid()
    {
        if (
            !isset($this->rules['rules'])
            || !isset($this->rules['rules']['draw'])
            || !isset($this->rules['rules']['draw']['numbers'])
            || !isset($this->rules['rules']['draw']['stars'])
            || !isset($this->rules['rules']['draw']['recurrency'])
            || !isset($this->rules['rules']['draw']['recurrency']['type'])
            || !isset($this->rules['rules']['draw']['recurrency']['value'])
        ) {
            return false;
        }

        return true;
    }
}
