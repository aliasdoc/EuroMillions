<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\Number;

class LoadNumberData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // @todo: get min and max values from DB
        $min = 1;
        $max = 50;
        for ($i = $min; $i <= $max; $i++) {
            $number = new Number();
            $number->setValue($i);
            $number->setTotal(0);

            $manager->persist($number);
            $manager->flush();
        }
    }
}
