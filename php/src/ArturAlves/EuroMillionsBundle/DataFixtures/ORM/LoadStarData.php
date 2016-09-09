<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\Star;

class LoadStarData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // @todo: get min and max values from DB
        $min = 1;
        $max = 11;
        for ($i = $min; $i <= $max; $i++) {
            $star = new Star();
            $star->setValue($i);
            $star->setTotal(0);

            $manager->persist($star);
            $manager->flush();
        }
    }
}
