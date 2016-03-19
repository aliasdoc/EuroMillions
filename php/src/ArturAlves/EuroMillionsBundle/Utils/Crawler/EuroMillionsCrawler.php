<?php
namespace ArturAlves\EuroMillionsBundle\Utils\Crawler;

class EuroMillionsCrawler extends Crawler
{
    /**
     * Executes the crawler and gets the draw's results
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return array|null The draw's results or null if the date is not set
     */
    public function crawl()
    {
        if (!isset($this->date)) {
            return null;
        }

        $url = "http://pt.euro-millions.com/resultados/" . date('d-m-Y', $this->date);
        $domDomcument = $this->getContentFrom($url, true);

        $numberWraperDomNode = $domDomcument->getElementById('jsBallOrderCell');
        $numbersDomNodes = $numberWraperDomNode->getElementsByTagName('li');

        $crawlResults = array(
            "numbers" => array(),
            "stars" => array(),
        );
        foreach ($numbersDomNodes as $key => $numberDomNode) {
            if ($key < 5) {
                $crawlResults['numbers'][] = $numberDomNode->nodeValue;
            } else {
                $crawlResults['stars'][] = $numberDomNode->nodeValue;
            }
        }

        $this->hasCrawled = true;

        return $crawlResults;
    }

    /**
     * Sets the draw's date
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  int $date An Unix timestamp of the draw's date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
