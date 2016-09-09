<?php

namespace ArturAlves\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// use ArturAlves\EuroMillionsBundle\Utils\Crawler\EuroMillionsCrawler;
use ArturAlves\EuroMillionsBundle\Entity\Number;
use ArturAlves\EuroMillionsBundle\Entity\NumberRepository;

// use ArturAlves\EuroMillionsBundle\Helper\RulesHelper;

/**
 * Imports the latest draws
 */
class BasicStatisticsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('aa:basic-statistics')
            ->setDescription('Calculate all basic statistics')
        ;
    }

    /**
     * Command's main execution
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @param  InputInterface $input [description]
     * @param  OutputInterface $output [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $rules = RulesHelper::getInstance($this->getContainer());
        // die("--".$rules->getNumbersCount());

        $em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw');
        $draws = $drawRepository->findAll();

        $totals = array();
        foreach ($draws as $draw) {
            $numbers = $draw->getNumbers();

            foreach ($numbers as $number) {
                $numberValue = $number->getValue();
                if (!isset($totals[$numberValue])) {
                    $totals[$numberValue] = 0;
                }
                $totals[$numberValue] += 1;
            }
        }

        $numberRepo = $em->getRepository('ArturAlvesEuroMillionsBundle:Number');
        foreach ($totals as $key => $value) {
            $number = $numberRepo->findOneBy(array('value' => $key));
            $number->setTotal($value);

            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate($number);
            if (count($errors) > 0) {
                $output->writeln("Error: ".json_encode($errors));
            } else {
                $em->persist($number);
                $em->flush();
            }
        }
        // $basicStatsRepo = $em->getRepository('ArturAlvesEuroMillionsBundle:BasicStatistics');
        // $basicStatsRepo

        var_dump($totals);

        $output->writeln("Execution terminated successfully");
    }
}
