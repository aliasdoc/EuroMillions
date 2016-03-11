<?php
namespace AA\EuroMillionsBundle\Utils\Crawler;

abstract class Crawler
{
    /**
     * Gets the content of a URL
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  string $url The URL from where the output will come
     * @param  boolean $returnDomDocument Defines if the return will be a string or a DOMDocument object
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
            return "";
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_use_internal_errors(false);
        return $doc;
    }

    /**
     * Executes the crawler
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    abstract public function crawl();
}
