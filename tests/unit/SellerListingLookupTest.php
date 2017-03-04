<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class SellerListingLookupTest extends \Codeception\Test\Unit
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
            'Id' => '1904034535',
            'IdType' => 'ASIN',
            'SellerId' => 'XXXYYY',
            'ResponseGroup' => 'SellerListing',
            'Timestamp' => '2011-03-03T16:05:49.0000'
        ];
        $url = $gen->sellerListingLookup($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&Id=1904034535' .
            '&IdType=ASIN' .
            '&Operation=SellerListingLookup' .
            '&ResponseGroup=SellerListing' .
            '&SellerId=XXXYYY' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=6b7O2ecqIxr%2FKeTg6rglGrH8RWUZPrn4Hn77s4ijRdk%3D';
        $this->assertEquals( $url, $expected );
    }
}
