<?php

namespace ArturAlves\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;

/**
 * Imports the latest draws.
 */
class BasicStatisticsCommand extends ContainerAwareCommand
{
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
     * Command's main execution.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        unset($input);

        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Draw');
        $draws = $drawRepository->findAll();

        $numberFrequencies = array();
        $starFrequencies = array();
        $numbersLastOccurrence = array();
        $starsLastOccurrence = array();
        $totalNumbers = 0;
        $totalStars = 0;
        foreach ($draws as $draw) {
            $numberFrequencies = $this->calcFrequency($numberFrequencies, $draw->getNumbers());
            $totalNumbers += count($draw->getNumbers());
            $numbersLastOccurrence = $this->calcLastOccurrence(
                $numbersLastOccurrence,
                $draw->getNumbers(),
                $draw->getDate()
            );

            $starFrequencies = $this->calcFrequency($starFrequencies, $draw->getStars());
            $totalStars += count($draw->getStars());
            $starsLastOccurrence = $this->calcLastOccurrence(
                $starsLastOccurrence,
                $draw->getStars(),
                $draw->getDate()
            );
        }
        unset($drawRepository, $draws);

        $numberRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Number');
        $this->saveStats($numberRepo, array(
            'frequency' => $numberFrequencies,
            'total' => $totalNumbers,
            'occurrences' => $numbersLastOccurrence,
        ));
        unset($numberRepo, $numberFrequencies);

        $starRepo = $this->em->getRepository('ArturAlvesEuroMillionsBundle:Star');
        $this->saveStats($starRepo, array(
            'frequency' => $starFrequencies,
            'total' => $totalStars,
            'occurrences' => $starsLastOccurrence,
        ));
        unset($starRepo, $starFrequencies);

        $output->writeln('Execution terminated successfully');
    }

    /**
     * Gets each number and star's frequency.
     *
     * @since  0.1.0
     *
     * @param DoctrineArrayCollection $elements
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
            $frequencies[$value] += 1;
        }

        return $frequencies;
    }

    /**
     * Gets each number and star's last occurrence.
     *
     * @since  0.1.0
     *
     * @param DoctrineArrayCollection $elements
     * @param \DateTime               $elements
     *
     * @return array Last occurrence of each number/star
     */
    private function calcLastOccurrence(array $occurrences, DoctrineArrayCollection $elements, \Datetime $date)
    {
        foreach ($elements as $element) {
            $value = $element->getValue();
            $occurrences[$value] = $date;
        }

        return $occurrences;
    }

    /**
     * Persists all calculated statistics.
     *
     * @since  0.1.0
     *
     * @param EntityRepository $repository The entity to persist
     * @param array            $data       The data to persist
     *
     * @return bool FALSE if there was any error, TRUE otherwise
     */
    private function saveStats($repository, array $data)
    {
        $frequencies = $data['frequency'];

        foreach ($frequencies as $key => $value) {
            $entity = $repository->findOneBy(array('value' => $key));
            $entity->setFrequency($value);
            $relativeFrequency = $value / $data['total'];
            $entity->setRelativeFrequency($relativeFrequency);
            $entity->setPercentage($relativeFrequency * 100);
            $entity->setLastOccurrence($data['occurrences'][$key]);

            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate($entity);
            if (count($errors) > 0) {
                $this->output->writeln('Error: '.json_encode($errors));

                return false;
            }

            $this->em->persist($entity);
        }
        $this->em->flush();

        return true;
    }
}
