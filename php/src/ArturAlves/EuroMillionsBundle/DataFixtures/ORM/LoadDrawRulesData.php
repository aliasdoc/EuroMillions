<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ArturAlves\EuroMillionsBundle\Entity\DrawRules;

class LoadDrawRulesData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $initialRules = new DrawRules();
        $initialRules
            ->setNumberCount(5)
            ->setNumberMinValue(1)
            ->setNumberMaxValue(50)
            ->setStarCount(2)
            ->setStarMinValue(1)
            ->setStarMaxValue(9)
            ->setWeekDays("Tue")
            ->setIsActive(false)
            ->setActiveSince(new \DateTime("2004-02-13"))
            ->setActiveUntil(new \DateTime("2011-05-06"));

        $manager->persist($initialRules);
        $manager->flush();

        $activeRules = clone $initialRules;
        $activeRules
            ->setStarMaxValue(11)
            ->setWeekDays("Tue,Fri")
            ->setIsActive(true)
            ->setActiveSince(new \DateTime("2011-05-10"))
            ->setActiveUntil(null);

        $manager->persist($activeRules);
        $manager->flush();
    }
}
