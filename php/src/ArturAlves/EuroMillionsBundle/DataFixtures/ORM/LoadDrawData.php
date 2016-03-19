<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\Draw;

class LoadDrawData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $draw = new Draw();
        $draw->setResult('{"numbers":[4,37,38,39,44],"stars":[4,7]}');
        $draw->setDate("2016-01-01");

        $manager->persist($draw);
        $manager->flush();
    }
}
