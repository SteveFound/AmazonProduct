<?php

use Dns\AmazonProduct\URLGenerator\ProductURLGenerator;


class ItemLookupTest extends \Codeception\Test\Unit
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
            'Condition' => 'All',
            'IdType' => 'ASIN',
            'ItemId' => '1904034535',
            'MerchantId' => 'Amazon',
            'ResponseGroup' => 'Medium',
            'sort' => 'salesrank',
            'Timestamp' => '2011-03-03T16:05:49.0000'
        ];

        $url = $gen->itemLookup($params);

        $expected = 'http://ecs.amazonaws.co.uk/onca/xml' .
            '?AWSAccessKeyId=12345678901234567890' .
            '&AssociateTag=XX00-11' .
            '&Condition=All' .
            '&IdType=ASIN' .
            '&ItemId=1904034535' .
            '&MerchantId=Amazon' .
            '&Operation=ItemLookup' .
            '&ResponseGroup=Medium' .
            '&Service=AWSECommerceService' .
            '&Timestamp=2011-03-03T16%3A05%3A49.0000' .
            '&sort=salesrank' .
            '&Signature=RLh0auSeFqH7XfVjsZtfGP6B3gZmjx5W3kAZOoR5LoE%3D';
        $this->assertEquals( $url, $expected );
    }
}
