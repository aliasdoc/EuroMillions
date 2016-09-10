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

    private $intput;
    private $output;

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
     * @param  InputInterface $input [description]
     * @param  OutputInterface $output [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        // $rules = RulesHelper::getInstance($this->getContainer());
        // die("--".$rules->getNumbersCount());

        $em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw');
        $draws = $drawRepository->findAll();

        $numberTotals = array();
        $starTotals = array();
        foreach ($draws as $draw) {
            $numberTotals = $this->calcTotal($draw->getNumbers());
            $starTotals = $this->calcTotal($draw->getStars());
        }
        unset($drawRepository, $draws);

        $numberRepo = $em->getRepository('ArturAlvesEuroMillionsBundle:Number');
        $this->saveStats($numberRepo, $numberTotals);
        unset($numberRepo, $numberTotals);

        $starRepo = $em->getRepository('ArturAlvesEuroMillionsBundle:Star');
        $this->saveStats($starRepo, $starTotals);
        unset($starRepo, $starTotals);

        $output->writeln("Execution terminated successfully");
    }

    /**
     * Gets each number and star's total
     *
     * @since  {nextRelease}
     *
     * @param  ArrayCollection $elements
     *
     * @return array Totals of each number/star
     */
    private function calcTotal(ArrayCollection $elements)
    {
        $totals = array();
        foreach ($elements as $element) {
            $value = $element->getValue();
            if (!isset($totals[$value])) {
                $totals[$value] = 0;
            }
            if (!isset($totals[$value])) {
                $totals[$value] = 0;
            }
            $totals[$value] += 1;
        }
        return $totals;
    }

    /**
     * Persists all calculated statistics.
     *
     * @since  {nextRelease}
     *
     * @param  EntityRepository $repository The entity to persist
     * @param  array $totals The data to persist
     *
     * @return boolean FALSE if there was any error, TRUE otherwise.
     */
    private function saveStats(EntityRepository $repository, array $totals)
    {
        foreach ($totals as $key => $value) {
            $entity = $repository->findOneBy(array('value' => $key));
            $entity->setTotal($value);

            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                $this->output->writeln("Error: ".json_encode($errors));
                return false;
            }

            $em->persist($entity);
            $em->flush();
            return true;
        }
    }
}
