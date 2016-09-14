<?php

namespace ArturAlves\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;

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
            ->setName('aa:basic-stats')
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

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Draw');
        $draws = $drawRepository->findAll();

        $numberFrequencies = array();
        $starFrequencies = array();
        foreach ($draws as $draw) {
            $numberFrequencies = $this->calcFrequency($numberFrequencies, $draw->getNumbers());
            $starFrequencies = $this->calcFrequency($starFrequencies, $draw->getStars());
        }
        // @todo: remover estes valores daqui
        $totalNumbers = count($draws) * 5;
        $totalStars = count($draws) * 2;

        unset($drawRepository, $draws);

        $numberRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Number');
        $this->saveStats($numberRepo, array(
            'frequency' => $numberFrequencies,
            'total' => $totalNumbers
        ));
        unset($numberRepo, $numberFrequencies);

        $starRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Star');
        $this->saveStats($starRepo, array(
            'frequency' => $starFrequencies,
            'total' => $totalStars
        ));
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
     * @param  array $data The data to persist
     *
     * @return boolean FALSE if there was any error, TRUE otherwise.
     */
    private function saveStats($repository, array $data)
    {
        $frequencies = $data['frequency'];

        foreach ($frequencies as $key => $value) {
            $entity = $repository->findOneBy(array('value' => $key));
            $entity->setFrequency($value);
            $entity->setPercentage($value / $data['total']);

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
