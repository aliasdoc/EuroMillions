<?php

namespace ArturAlves\EuroMillionsBundle\Tests\Utils\Crawler;

use ArturAlves\EuroMillionsBundle\Utils\Crawler\EuroMillionsCrawler;

class EuroMillionsCrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function testCrawl()
    {
        $crawler = new EuroMillionsCrawler();

        $this->assertFalse($crawler->hasCrawled());
        $result = $crawler->crawl();
        $this->assertNull($result);
        $this->assertFalse($crawler->hasCrawled());

        $crawler->setDate(strtotime('2016-01-01'));
        $result = $crawler->crawl();
        $this->assertArrayHasKey('numbers', $result);
        $this->assertArrayHasKey('stars', $result);
    }
}
