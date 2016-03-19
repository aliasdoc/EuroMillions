<?php

namespace ArturAlves\EuroMillionsBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Rules
{
    private $drawRules;

    public function __construct(Container $container)
    {
        $rules = $container->getParameter('artur_alves_euro_millions.rules');
        $this->drawRules = $rules['draw'];
    }

    public function getNumbersCount()
    {
        if (!is_int($this->drawRules['numbers']['count'])) {
            throw new Exception("The parameter 'artur_alves_euro_millions_rules_draw_numbers_count' is not a valid integer");
        }
        return $this->drawRules['numbers']['count'];
    }

    public function getRecurrency()
    {
        return $this->drawRules['recurrency']['value'];
    }

    public function getRecurrencyType()
    {
        $validTypes = array("daily", "weekly", "monthly");
        $type = $this->drawRules['recurrency']['type'];
        if(!in_array($type, $validTypes)) {
            throw new Exception("The parameter 'artur_alves_euro_millions_rules_draw_recurrency_type' is not a valid type");
        }
        return $type;
    }

    public function getStarsCount()
    {
        if (!is_int($this->drawRules['stars']['count'])) {
            throw new Exception("The parameter 'artur_alves_euro_millions_rules_draw_stars_count' is not a valid integer");
        }
        return (int) $this->drawRules['stars']['count'];
    }
}
