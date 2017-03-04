<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class SimilarityLookupTest extends \Codeception\Test\Unit
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
            'ItemId' => '1904034535',
            'Timestamp' => '2011-03-03T16:05:49.0000'
        ];
        $url = $gen->similarityLookup($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&ItemId=1904034535' .
            '&Operation=SimilarityLookup' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=TxajmOQRK8NjnRR4smpj%2BKCTlSIMfl46HIOUmMz3MhY%3D';
        $this->assertEquals( $url, $expected );
    }
}
