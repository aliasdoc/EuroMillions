<?php

namespace ArturAlves\EuroMillionsBundle\Utils\Crawler;

class Crawler
{
    protected $hasCrawled;

    /**
     * Constructor.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function __construct()
    {
        $this->hasCrawled = false;
    }

    /**
     * Executes the crawler.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function crawl()
    {
        $this->hasCrawled = true;
    }

    /**
     * Gets the content of a URL.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param string $url               The URL from where the output will come
     * @param bool   $returnDomDocument Defines if the return will be a string or a DOMDocument object
     *
     * @return string|DOMDocument The $url output string or a DOMDocument
     */
    public function getContentFrom($url, $returnDomDocument = false)
    {
        if (!$returnDomDocument) {
            return file_get_contents($url);
        }

        $content = file_get_contents($url);
        if (empty($content)) {
            return '';
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_use_internal_errors(false);

        return $doc;
    }

    /**
     * Checks if the crawler has crawled.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return bool True if the crawler has executed, false otherwise
     */
    public function hasCrawled()
    {
        return $this->hasCrawled;
    }
}
