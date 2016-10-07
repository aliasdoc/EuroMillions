<?php

namespace ArturAlves\EuroMillionsBundle\Tests\Utils\Crawler;

use ArturAlves\EuroMillionsBundle\Utils\Crawler\Crawler;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContentFrom()
    {
        $testUrl = 'https://phpunit.de/';
        $crawler = new Crawler();

        // Testing the getContentFrom function
        // Will return false on error
        $result = $crawler->getContentFrom($testUrl);
        $this->assertFalse(!$result);
        $this->assertSame($result, file_get_contents($testUrl));

        // Testing the $hasCrawled property
        $this->assertFalse($crawler->hasCrawled());
        $crawler->crawl();
        $this->assertTrue($crawler->hasCrawled());
    }
}
