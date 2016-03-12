<?php
namespace AA\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AA\EuroMillionsBundle\Entity\Draw;

class LoadDrawData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $draw = new Draw();
        $draw->setNumber1('4');
        $draw->setNumber2('37');
        $draw->setNumber3('38');
        $draw->setNumber4('39');
        $draw->setNumber5('44');
        $draw->setStar1('4');
        $draw->setStar2('7');
        $draw->setDate("2016-01-01");

        $manager->persist($draw);
        $manager->flush();
    }
}
