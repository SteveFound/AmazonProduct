<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class CartAddTest extends \Codeception\Test\Unit
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
        $offers = [
            'ListingId0001' => 3,
            'ListingId0002' => 1,
            'ListingId0003' => 2
        ];
        $url = $gen->cartAdd(1, 'HMAC1234', $offers, $params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&CartId=1' .
            '&HMAC=HMAC1234' .
            '&Id=1904034535' .
            '&IdType=ASIN' .
            '&Item.1.OfferListingId=ListingId0001' .
            '&Item.1.Quantity=3' .
            '&Item.2.OfferListingId=ListingId0002' .
            '&Item.2.Quantity=1' .
            '&Item.3.OfferListingId=ListingId0003' .
            '&Item.3.Quantity=2' .
            '&Operation=CartAdd' .
            '&ResponseGroup=SellerListing' .
            '&SellerId=XXXYYY' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&Signature=ucxrID%2FCpkdpIee82a81xY9naCug1m1raRl3ZoPVSKI%3D';
        $this->assertEquals( $url, $expected );
    }
}
