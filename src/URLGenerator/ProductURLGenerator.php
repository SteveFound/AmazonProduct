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

}
