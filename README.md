## postcode-api-nu
[![Build Status](https://travis-ci.org/niborb/postcode-api-nu.png?branch=master)](https://travis-ci.org/niborb/postcode-api-nu)
### PHP Library for the free Dutch Postcode API NU service: postcodeapi.nu

### Installation

You have to request an API Key from postcodeapi.nu to be able to use the postcode service. (it's free!)
- http://www.postcodeapi.nu/#benefits-developers-tab

You can install the library with Composer. 

    composer.phar require "niborb/postcode-api-nu=dev-master"
    
The library needs a PSR-0 loader, like the one Composer provides.

### Usage

```php
<?php
require 'vendor/autoload.php';

use Niborb\PostcodeAPI\PostcodeAPI;

$apiKey = '###YOUR-POSTCODE-API-NU-KEY###';
$service = new PostCodeAPI($apiKey);

// postalcode + housenumber
$address = $service->getAddressByPostalcodeAndHouseNumber('5041EB', 21);
echo $address . "\n\n";

// only by postalcode
$address = $service->getAddressByPostalcode('5041EB');
echo $address . "\n\n";

// by geo latitude and longitude
$address = $service->getAddressByLatitudeAndLongitude(51.5664, 5.07718);
echo $address . "\n\n";

```

Output:
    
    Street: Wilhelminapark 21
    Postalcode: 5041EB
    Town: Tilburg
    Municipality: Tilburg
    Province: Noord-Brabant
    Latitude: 51,5664
    Longitude: 5,07718

    Street: Wilhelminapark 
    Postalcode: 5041EB
    Town: Tilburg
    Municipality: Tilburg
    Province: Noord-Brabant
    Latitude: 51,5663166667
    Longitude: 5,0771925


    Street: Wilhelminapark 21
    Postalcode: 5041EB
    Town: Tilburg
    Municipality: Tilburg
    Province: Noord-Brabant
    Latitude: 51,5664
    Longitude: 5,07718


