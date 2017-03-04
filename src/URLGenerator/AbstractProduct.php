<?php
namespace Dns\AmazonProduct\URLGenerator;

abstract class AbstractProduct {
    /**
     * Available Locales
     */
    const LOCALE_US = 'us';
    const LOCALE_UK = 'uk';
    const LOCALE_CANADA = 'ca';
    const LOCALE_FRANCE = 'fr';
    const LOCALE_GERMANY = 'de';
    const LOCALE_JAPAN = 'jp';

    /**
     * The Amazon locale to use by default.
     */
    private $locale;

   /**
    * Associate Tag
    */
    private $AssociateTag;

    /**
     * Developer Tag
     */
    private $AWSAccessKeyId;

    /**
     * Amazon supplied secret key
     */
    private $AWSSecretKey;

    /**
     * Server URL which is set by setLocale
     */
    private $AWSEndPoint;

    /**
     * Set the AWS keys required by the Amazon Product Advertising API. Setting
     * them through a method allows them to be set by a simple call which is useful
     * for testing.
     * @param string $access Your 20 character AWS developer access key.
     * @param string $secret Your 40 character AWS secret key used for calculating the signature
     * @param string $associate Your Amazon Associate ID
     */
    public function setKeys($access, $secret, $associate)
    {
        $this->AWSAccessKeyId = $access;
        $this->AWSSecretKey = $secret;
        $this->AssociateTag = $associate;
    }

    /**
     * Set the locale to use
     * @param String $locale LOCALE_CANADA, LOCALE_FRANCE, LOCALE_GERMANY, LOCALE_JAPAN, LOCALE_UK or LOCALE_US
     */
    public function setLocale($locale = null)
    {
        $this->locale = $locale;
        // Determine the hostname
        switch ($locale)
        {
            // United Kingdom
            case self::LOCALE_UK:
                $this->AWSEndPoint = 'ecs.amazonaws.co.uk';
                break;

            // Canada
            case self::LOCALE_CANADA:
                $this->AWSEndPoint = 'ecs.amazonaws.ca';
                break;

            // France
            case self::LOCALE_FRANCE:
                $this->AWSEndPoint = 'ecs.amazonaws.fr';
                break;

            // Germany
            case self::LOCALE_GERMANY:
                $this->AWSEndPoint = 'ecs.amazonaws.de';
                break;

            // Japan
            case self::LOCALE_JAPAN:
                $this->AWSEndPoint = 'ecs.amazonaws.jp';
                break;

            // Default to United States
            default:
                $this->AWSEndPoint = 'ecs.amazonaws.com';
                break;
        }
    }

    /**
     * Sign the parameters
     * The parameters are signed by calculating a 'Signature' parameter which
     * is added in to the request
     * @param array $params an associative array of Amazon request parameters
     * @return parameter array with a Signature parameter added
     */
    private function sign( $params ) {
        if( isset($this->AssociateTag)){
            $params['AssociateTag'] = $this->AssociateTag;
        }
        $params['AWSAccessKeyId'] = $this->AWSAccessKeyId;
        $params['Service'] = 'AWSECommerceService';
        // add a Timestamp to the request unless it's already set.
        if( !array_key_exists('Timestamp', $params )){
            $params['Timestamp'] = date("Y-m-d\TH:i:s.000Z");
        }
        // Sort the parameters alphabetically by key
        ksort($params);
        // get the canonical form of the query string
        $canonical = $this->canonicalize($params);
        // construct the data to be signed as specified in the docs
        $stringToSign = 'GET' . "\n" .
                        $this->AWSEndPoint . "\n" .
                        '/onca/xml' . "\n" .
                        $canonical;

        // calculate the signature value and add it to the request.
        $params['Signature'] = base64_encode(hash_hmac("sha256", $stringToSign, $this->AWSSecretKey, True));
        return $params;
    }


    /**
     * Constructs the canonical form of the query string as specified in the docs.
     * @param array $params query parameters sorted alphabetically by key
     * @return string canonical form of the query string
     */
    private function canonicalize($params) {
        $parts = array();
        foreach( $params as $k => $v){
            $x = rawurlencode($k) . '=' . rawurlencode($v);
            array_push($parts, $x );
        }
        return implode('&',$parts);
    }


    /**
     * Construct a signed URL to request an Amazon REST response
     * @param $par request parameters
     * @return string canonical form of the Amazon QueryURL
     */
    protected function getAmazonURL( $operation, $params ){
        $params['Operation'] = $operation;
        return 'http://' . $this->AWSEndPoint . '/onca/xml' .
                '?' . $this->canonicalize($this->sign($params));
    }
}
