<?php

namespace AA\EuromilhoesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $drawRepository = $em->getRepository('AAEuromilhoesBundle:Draw');

        // Gets the last draw stored in the database
        $latestDraw = $drawRepository->getLatestDraw();

        // Finds out which dates since $latestDraw also had draws
        $latestDrawDate = $latestDraw->getDate()->format('Y-m-d');
        $latestDrawDates = $drawRepository->getDrawDatesSince($latestDrawDate);
        if (count($latestDrawDates)) {
            $output->writeln("Latest draw dates: ".json_encode($latestDrawDates));
        } else {
            $output->writeln("[".date("Y-m-d", strtotime("today")) . "] - Nothing to update");
        }

        foreach ($latestDrawDates as $key => $date) {
            // Obtains the results of each draw
            $result = $this->getDrawResult($date);

            // Creates a new Draw and stores it in the database
            $draw = $drawRepository->fromArray($result);
            $draw->setDate($date);
            $em->persist($draw);
            $em->flush();
        }
    }

    /**
     * Gets the result of a certain draw by its date
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @param  string $date The date as 'Y-m-d'
     *
     * @return array The draw's result
     */
    private function getDrawResult($date)
    {
        $date = date('d-m-Y', strtotime($date));
        $siteContent = file_get_contents("http://pt.euro-millions.com/resultados/".$date);
        if (empty($siteContent)) {
            $output->writeln("Error getting draw information.");
            die;
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        if(!$doc->loadHTML($siteContent)) {
            $output->writeln("Failed to load html");
            die;
        }
        libxml_use_internal_errors(false);
        $numberWraperDomNode = $doc->getElementById('jsBallOrderCell');
        $numbersDomNodes = $numberWraperDomNode->getElementsByTagName('li');

        $result = array(
            "numbers" => array(),
            "stars" => array(),
        );
        foreach ($numbersDomNodes as $key => $numberDomNode) {
            if ($key < 5) {
                $result['numbers'][] = $numberDomNode->nodeValue;
            } else {
                $result['stars'][] = $numberDomNode->nodeValue;
            }
        }

        return $result;
    }
}
