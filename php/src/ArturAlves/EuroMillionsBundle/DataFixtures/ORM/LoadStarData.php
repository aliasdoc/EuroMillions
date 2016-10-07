<?php

namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\Star;

class LoadStarData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $min = 1;
        $max = 11;
        for ($i = $min; $i <= $max; ++$i) {
            $star = new Star();
            $star->setValue($i)
                ->setFrequency(0)
                ->setRelativeFrequency(0)
                ->setPercentage(0);

            $manager->persist($star);
            $manager->flush();
        }
    }
}
