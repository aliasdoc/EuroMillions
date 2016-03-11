<?php

namespace AA\EuroMillionsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AA\EuroMillionsBundle\Utils\Crawler\EuroMillionsCrawler;

/**
 * Imports the latest draws
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
     * Command's main execution
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @param  InputInterface $input [description]
     * @param  OutputInterface $output [description]
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $drawRepository = $em->getRepository('AAEuroMillionsBundle:Draw');

        // Gets the last draw stored in the database
        $latestDraw = $drawRepository->getLatestDraw();

        // Finds out which dates since $latestDraw also had draws
        $latestDrawDate = $latestDraw->getDate()->format('Y-m-d');
        $latestDrawDates = $drawRepository->getDrawDatesSince($latestDrawDate);
        if (count($latestDrawDates) == 0) {
            $output->writeln("[".date("Y-m-d", strtotime("today")) . "] - Nothing to update");
        } else {
            $output->writeln("Latest draw dates: ".json_encode($latestDrawDates));

            $crawler = new EuroMillionsCrawler();
            foreach ($latestDrawDates as $key => $date) {
                // Obtains the results of each draw
                $crawler->setDate(strtotime($date));
                $result = $crawler->crawl();

                // Creates a new Draw and stores it in the database
                $draw = $drawRepository->fromArray($result);
                $draw->setDate($date);
                $em->persist($draw);
                $em->flush();
            }
        }

        $output->writeln("Execution terminated successfully");
    }
}
