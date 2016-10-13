<?php

namespace ArturAlves\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ArturAlves\EuroMillionsBundle\Utils\Crawler\EuroMillionsCrawler;
use ArturAlves\EuroMillionsBundle\Entity\Draw;

/**
 * Imports the latest draws.
 */
class UpdateDrawsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('aa:update-draws')
            ->setDescription('Get the latest draw results')
        ;
    }

    /**
     * Command's main execution.
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @param InputInterface  $input  [description]
     * @param OutputInterface $output [description]
     *
     * @return bool FALSE if there was any error, TRUE otherwise
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw');

        // Gets the last draw stored in the database
        $latestDraw = $drawRepository->getLatestDraw();

        // Finds out which dates since $latestDraw also had draws
        $latestDrawDate = $latestDraw->getDate()->format('Y-m-d');
        $latestDrawDates = $drawRepository->getDrawDatesSince($latestDrawDate);
        if (count($latestDrawDates) == 0) {
            $output->writeln('['.date('Y-m-d', strtotime('today')).'] - Nothing to update');
            return false;
        }

        $output->writeln('Latest draw dates: '.json_encode($latestDrawDates));

        $crawler = new EuroMillionsCrawler();
        foreach ($latestDrawDates as $date) {
            // Obtains the results of each draw
            $crawler->setDate(strtotime($date));
            $result = $crawler->crawl();

            // Creates a new Draw and stores it in the database
            $draw = new Draw();
            $draw->setResult(json_encode($result));
            $draw->setDate($date);

            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate($draw);
            if (count($errors) > 0) {
                $output->writeln('Error: '.json_encode($errors));
                continue;
            }
            $em->persist($draw);
        }
        $em->flush();

        $output->writeln('Execution terminated successfully');
    }
}
