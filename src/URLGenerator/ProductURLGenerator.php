<?php
namespace Dns\AmazonProduct\URLGenerator;

/**
 * This class generates URL's to access the Amazon Product Advertising Service.
 * Each entry point requires an array of parameters to send with each request
 * and the format of the parameters can be found on the Amazon website. See the
 * unit tests for examples. To generate the URL's you will require the keys issued
 * to you by Amazon when you register to use the service.
 */
class ProductURLGenerator extends AbstractProduct
{
    /**
     * Lookup a specific Item
     * @param array $parameters
     * @return string URL to request the item
     */
    public function itemLookup(array $parameters)
    {
        return $this->getAmazonURL('ItemLookup', $parameters);
    }

    /**
     * Search for items
     * @param array $parameters
     * @return string URL to request the item
     */
    public function itemSearch(array $parameters)
    {
        return $this->getAmazonURL('ItemSearch', $parameters);
    }

    /**
     * Lookup a seller listing
     * @param array $parameters
     * @return string URL to request the item
     */
    public function sellerListingLookup(array $parameters)
    {
        return $this->getAmazonURL('SellerListingLookup', $parameters);
    }

    /**
     * Search for a seller listing
     * @param array $parameters
     * @return string URL to request the item
     */
    public function sellerListingSearch(array $parameters)
    {
        return $this->getAmazonURL('SellerListingSearch', $parameters);
    }

    /**
     * Lookup a seller
     * @param array $parameters
     * @return string URL to request the item
     */
    public function sellerLookup(array $parameters)
    {
        return $this->getAmazonURL('SellerLookup', $parameters);
    }

    /**
     * Lookup similar items
     * @param array $parameters
     * @return string URL to request the item
     */
    public function similarityLookup(array $parameters)
    {
        return $this->getAmazonURL('SimilarityLookup', $parameters);
    }


    /**
     * Lookup a browse node
     * @param array $parameters
     * @return string URL to request the item
     */
    public function browseNodeLookup(array $parameters)
    {
        return $this->getAmazonURL('BrowseNodeLookup', $parameters);
    }

    /**
     * Add items to an existing cart
     * @param string $cart_id  Alphanumeric token returned by <cartCreate()>
     * @param string $hmac Encrypted alphanumeric access token returned by <cartCreate()>
     * @param mixed $offers Either a string containing the Offer ID to add or an associative array where the Offer ID is the key and the quantity is the value. An offer listing ID is an alphanumeric token that uniquely identifies an item. Use the OfferListingId instead of an item's ASIN to add the item to the cart.
     * @param array $parameters Associative array of parameters
     * @return string URL to request the item
     */
    public function cartAdd($cart_id, $hmac, $offers, array $parameters = array()){
        $parameters['CartId'] = $cart_id;
        $parameters['HMAC'] = $hmac;

        if (is_array($offers)) {
            $count = 1;
            foreach ($offers as $offer => $quantity) {
                $parameters['Item.' . $count . '.OfferListingId'] = $offer;
                $parameters['Item.' . $count . '.Quantity'] = $quantity;
                $count++;
            }
        } else {
            $parameters['Item.1.OfferListingId'] = $offers;
            $parameters['Item.1.Quantity'] = 1;
        }

        return $this->getAmazonURL('CartAdd', $parameters);
    }

    /**
     * Clear a cart
     * @param string $cart_id  Alphanumeric token returned by <cartCreate()>
     * @param string $hmac Encrypted alphanumeric access token returned by <cartCreate()>
     * @param array $parameters Associative array of parameters
     * @return string URL to request the item
     */
    public function cartClear($cart_id, $hmac, array $parameters = array()){
        $parameters['CartId'] = $cart_id;
        $parameters['HMAC'] = $hmac;
        return $this->getAmazonURL('CartClear', $parameters);
    }

    /**
     * Create a cart
     * @param mixed $offers Either a string containing the Offer ID to add or an associative array where the Offer ID is the key and the quantity is the value. An offer listing ID is an alphanumeric token that uniquely identifies an item. Use the OfferListingId instead of an item's ASIN to add the item to the cart.
     * @param array $parameters Associative array of parameters
     * @return string URL to request the item
     */
    public function cartCreate($offers, array $parameters = array()){
        if (is_array($offers)){
            $count = 1;
            foreach ($offers as $offer => $quantity){
                $parameters['Item.' . $count . '.OfferListingId'] = $offer;
                $parameters['Item.' . $count . '.Quantity'] = $quantity;
                $count++;
            }
        } else {
            $parameters['Item.1.OfferListingId'] = $offers;
            $parameters['Item.1.Quantity'] = 1;
        }
        return $this->getAmazonURL('CartCreate', $parameters);
    }

    /**
     * Retrieve a cart
     * @param string $cart_id  Alphanumeric token returned by <cartCreate()>
     * @param string $hmac Encrypted alphanumeric access token returned by <cartCreate()>
     * @param array $parameters Associative array of parameters
     * @return string URL to request the item
     */
    public function cartGet($cart_id, $hmac, array $parameters = array()) {
        $parameters['CartId'] = $cart_id;
        $parameters['HMAC'] = $hmac;
        return $this->getAmazonURL('CartGet', $parameters);
    }

    /**
     * Modify item quantities of cart items
     * @param string $cart_id  Alphanumeric token returned by <cartCreate()>
     * @param string $hmac Encrypted alphanumeric access token returned by <cartCreate()>
     * @param array $offers Associative array that specifies an item to be modified in the cart where N is a positive integer between 1 and 10, inclusive. Up to ten items can be modified at a time. CartItemId is neither an ASIN nor an OfferListingId. It is, instead, an alphanumeric token returned by <cart_create()> and <cart_add()>. This parameter is used in conjunction with Item.N.Quantity to modify the number of items in a cart. Also, instead of adjusting the quantity, you can set 'SaveForLater' or 'MoveToCart' as actions instead.
     * @param array $parameters Associative array of parameters
     * @return string URL to request the item
     */
    public function cartModify($cart_id, $hmac, $offers, array $parameters = array()){
        $parameters['CartId'] = $cart_id;
        $parameters['HMAC'] = $hmac;

        $count = 1;
        foreach ($offers as $offer => $quantity){
            $action = is_numeric($quantity) ? 'Quantity' : 'Action';
            $parameters['Item.' . $count . '.CartItemId'] = $offer;
            $parameters['Item.' . $count . '.' . $action] = $quantity;
            $count++;
        }
        return $this->getAmazonURL('CartModify', $parameters);
    }
}
