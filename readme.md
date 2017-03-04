# Amazon Product Advertising URL Generator

## Synopsis

This is a simple class to construct URL's to access the Amazon Product Advertising Service as detailed [on the Amazon web site](https://affiliate-program.amazon.co.uk/gp/advertising/api/detail/main.html). I have taken the approach of minimising the class to simply provide an entry point for each service and leave it to the user to supply the required parameters. This makes the code somewhat future proof as the paramaters and their allowed values change from time to time at the discretion of Amazon so it seems sensible to write the code so that it will not require modification each time the parameters change.

## Amazon Requirements

You will require the following 3 keys from Amazon to be able to use the plugin effectively.

**Amazon Associate ID**
This is issued by Amazon when you sign up as an associate. Being an associate allows you to earn some money from any sales Amazon make which are referred to them by you.

**Amazon Web Service Key and Secret Key**
These are issued by Amazon when you [sign up for AWS](http://aws.amazon.com)

## Code Example

The services available for this class are all detailed [on the Amazon web site](https://affiliate-program.amazon.co.uk/gp/advertising/api/detail/main.html). Parameters to each function are passed through an associated array. For example to build the request to ItemLookup for the Amazon item with the ASIN B00008OE6I, ```http://webservices.amazon.com/onca/xml?Service=AWSECommerceService&AWSAccessKeyId=[AWS Access Key ID]&AssociateTag=[Associate ID]&Operation=ItemLookup&ItemId=B00008OE6I&Timestamp=[YYYY-MM-DDThh:mm:ssZ]&Signature=[Request Signature]```

you would call:

```php

    $generator = new Dns\AmazonProduct\URLGenerator\ProductURLGenerator();
    $generator->setLocale(ProductURLGenerator::LOCALE_US);
    $generator->setKeys( '[AWS Access Key ID]', '[Secret Key]', '[Associate ID]');
    $url = $generator->itemLookup( [
        'ItemId' => 'B00008OE6I'
    ]);
```

    Note that if the parameter 'Timestamp' is not supplied it will be created at the time of URL creation.

## Motivation

Making a successful call to the Amazon product advertising API requires that three keys given to you by Amazon are used to construct a long URL which encodes the request. As well as the keys, which identify who is making the request, a sign parameter is also required to verify that the request has not altered since it was issued. This class constructs that URL, including the sign parameter. The URL can then be requested from Amazon and Amazon will return an XML response if the query is valid. This code ONLY constructs the URL, it does NOT send the request to Amazon as there are numerous HttpClient packages that you can use to do this.

## Installation
You should install this package with composer:

    composer require dns/amazonproduct:dev-master

## API Reference


*void setKeys($access, $secret, $associate)*

Set your keys for the request. **$access** is your 20 character developer key. **$secret** is your 40 character secret key used for calculating the signature and **$associate** is your Amazon Associate ID.

*void setLocale( string $locale )*

Set the locale for the Amazon server you want to query. The locale should be one of **ProductURLGenerator::LOCALE_US, ProductURLGenerator::LOCALE_UK, ProductURLGenerator::LOCALE_CANADA, ProductURLGenerator::LOCALE_FRANCE, ProductURLGenerator::LOCALE_GERMANY, ProductURLGenerator::LOCALE_JAPAN** which are defined as constants in the class.

*string itemLookup( array $params )*

Given an Item identifier, the ItemLookup operation returns some or all of the item attributes, depending on the response group specified in the request. By default, ItemLookup returns an item’s *ASIN*, *Manufacturer*, *ProductGroup*, and *Title* of the item.

*string itemSearch( array $params )*

The ItemSearch operation searches for items on Amazon. The Product Advertising API returns up to ten items per search results page. An ItemSearch request requires a search index and the value for at least one parameter. For example, you might use the BrowseNode parameter for Harry Potter books and specify the Books search index.

*string similarityLookup( array $params )*

The SimilarityLookup operation returns up to ten products per page that are similar to one or more items specified in the request. This operation is typically used to pique a customer’s interest in buying something similar to what they’ve already ordered.

*string browseNodeLookup( array $params )*

Given a browse node ID, BrowseNodeLookup returns the specified browse node’s name, children, and ancestors. The names and browse node IDs of the children and ancestor browse nodes are also returned. BrowseNodeLookup enables you to traverse the browse node hierarchy to find a browse node.

In all cases that return a string, the returned string is a URL that can be sent to Amazon to request the information required.

## Tests

A Codeception unit test exists for each function and can be executed by calling vendor/bin/codecept run unit

## License

MIT
