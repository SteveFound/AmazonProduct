<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class SellerListingSearchTest extends \Codeception\Test\Unit
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
            'SellerId' => '1904034535',
            'ListingPage' => '2',
            'OfferStatus' => 'Open',
            'Sort' => '+price',
            'Keywords' => 'thriller',
            'Timestamp' => '2011-03-03T16:05:49.0000'
        ];
        $url = $gen->sellerListingSearch($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&Keywords=thriller' .
            '&ListingPage=2' .
            '&OfferStatus=Open' .
            '&Operation=SellerListingSearch' .
            '&SellerId=1904034535' .
            '&Service=AWSECommerceService' .
            '&Sort=%2Bprice' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=4yPkGdgrGx41xg38YCddlmVIDLMVvzMnycwz0CygVvA%3D';
        $this->assertEquals( $url, $expected );
    }
}
