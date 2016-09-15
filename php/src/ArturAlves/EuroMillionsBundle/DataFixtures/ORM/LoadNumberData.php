<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\Number;

class LoadNumberData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $min = 1;
        $max = 50;
        for ($i = $min; $i <= $max; $i++) {
            $number = new Number();
            $number->setValue($i);
            $number->setFrequency(0);

            $manager->persist($number);
            $manager->flush();
        }
    }
}
