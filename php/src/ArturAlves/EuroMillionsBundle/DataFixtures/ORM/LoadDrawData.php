<?php
namespace ArturAlves\EuroMillionsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use ArturAlves\EuroMillionsBundle\Entity\Draw;

class LoadDrawData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = Yaml::parse(file_get_contents(dirname(__FILE__) . '/draw.yml'));
        foreach ($fixtures as $key => $fixture) {
            $draw = new Draw();
            $draw
                ->setId($fixture['id'])
                ->setResult($fixture['result'])
                ->setDate($fixture['date']);

            $manager->persist($draw);
            $manager->flush();
        }
    }
}
