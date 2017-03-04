<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class ItemSearchTest extends \Codeception\Test\Unit
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
            'SearchIndex'=>'Books',
            'Keywords'=>'harry+potter',
            'ResponseGroup'=>'Large',
            'Timestamp' => '2011-03-03T16:05:49.0000'        ];

        $url = $gen->itemSearch($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&Keywords=harry%2Bpotter' .
            '&Operation=ItemSearch' .
            '&ResponseGroup=Large' .
            '&SearchIndex=Books' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=wbrOtL5qVwOO4hItE%2FvJfFMOXzQdMGJHXchDue9DPgs%3D';
        $this->assertEquals( $url, $expected );
    }
}
