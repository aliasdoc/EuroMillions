<?php

namespace ArturAlves\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;
// use ArturAlves\EuroMillionsBundle\Helper\RulesHelper;

/**
 * Imports the latest draws
 */
class BasicStatisticsCommand extends ContainerAwareCommand
{
    /**
     * @var InputInterface
     */
    private $intput;

    /**
    * @var OutputInterface
    */
    private $output;

    /**
     * @var EntityManager
     */
    private $em;

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
     * @param  InputInterface $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        // $rules = RulesHelper::getInstance($this->getContainer());
        // die("--".$rules->getNumbersCount());

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Draw');
        $draws = $drawRepository->findAll();

        $numberFrequencies = array();
        $starFrequencies = array();
        foreach ($draws as $draw) {
            $numberFrequencies = $this->calcFrequency($numberFrequencies, $draw->getNumbers());
            $starFrequencies = $this->calcFrequency($starFrequencies, $draw->getStars());
        }
        unset($drawRepository, $draws);

        $numberRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Number');
        $this->saveStats($numberRepo, $numberFrequencies);
        unset($numberRepo, $numberFrequencies);

        $starRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Star');
        $this->saveStats($starRepo, $starFrequencies);
        unset($starRepo, $starFrequencies);

        $output->writeln("Execution terminated successfully");
    }

    /**
     * Gets each number and star's frequency
     *
     * @since  {nextRelease}
     *
     * @param  DoctrineArrayCollection $elements
     *
     * @return array Frequencies of each number/star
     */
    private function calcFrequency(array $frequencies, DoctrineArrayCollection $elements)
    {
        foreach ($elements as $element) {
            $value = $element->getValue();
            if (!isset($frequencies[$value])) {
                $frequencies[$value] = 0;
            }
            if (!isset($frequencies[$value])) {
                $frequencies[$value] = 0;
            }
            $frequencies[$value] += 1;
        }
        return $frequencies;
    }

    /**
     * Persists all calculated statistics.
     *
     * @since  {nextRelease}
     *
     * @param  EntityRepository $repository The entity to persist
     * @param  array $frequencies The data to persist
     *
     * @return boolean FALSE if there was any error, TRUE otherwise.
     */
    private function saveStats($repository, array $frequencies)
    {
        foreach ($frequencies as $key => $value) {
            $entity = $repository->findOneBy(array('value' => $key));
            $entity->setFrequency($value);

            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                $this->output->writeln("Error: ".json_encode($errors));
                return false;
            }

            $this->em->persist($entity);
            $this->em->flush();
        }

        return true;
    }
}
