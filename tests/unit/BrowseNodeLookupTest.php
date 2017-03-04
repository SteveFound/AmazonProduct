<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class BrowseNodeLookupTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testURLGeneration()
    {
        $gen = new ProductURLGenerator();
        $gen->setKeys('12345678901234567890', '1234567890123456789012345678901234567890', 'XX00-11');
        $gen->setLocale(ProductURLGenerator::LOCALE_UK);

        $params = [
            'BrowseNodeId' => '163357',
            'ResponseGroup' => 'NewReleases',
            'Timestamp' => '2011-03-03T16:05:49.0000'
        ];
        $url = $gen->browseNodeLookup($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&BrowseNodeId=163357' .
            '&Operation=BrowseNodeLookup' .
            '&ResponseGroup=NewReleases' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=ptAPnju4tE87Cw80YTXn7AUckcHechTExUCa4Ve5RC0%3D';
        $this->assertEquals( $url, $expected );

    }
}
