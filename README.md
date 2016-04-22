# PHP Google Geocoder

[![Latest Stable Version](https://poser.pugx.org/markenwerk/google-geocoder/v/stable)](https://packagist.org/packages/markenwerk/google-geocoder)
[![Total Downloads](https://poser.pugx.org/markenwerk/google-geocoder/downloads)](https://packagist.org/packages/markenwerk/google-geocoder)
[![License](https://poser.pugx.org/markenwerk/google-geocoder/license)](https://packagist.org/packages/markenwerk/google-geocoder)

A PHP library to query Google's location service for geolocation lookup based on a given address.

## Installation

```{json}
{
   	"require": {
        "markenwerk/google-geocoder": "~1.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

---

### Resolving an address

```{php}
try{
	// Perform lookup
	$addressLookup = new GoogleGeocode\AddressLookup();
	$addressLookup->lookup('Germany, 24105 Kiel, Lornsenstraße 43');

	// Retrieving the lookup as an array of GoogleGeocode\AddressLookupResult instances
	$lookupResults = $addressLookup->getResults();

	// Get the number of lookup results
	$lookupResultCount = $addressLookup->getResultCount();

	// Retrieving the first lookup result as GoogleGeocode\AddressLookupResult instance
	$firstResult = $addressLookup->getFirstResult();

	// Retrieving the address information from the lookup result
	// Returns 'Lornsenstraße'
	$addressStreetShort = $firstResult->getAddress()->getStreetName()->getShortName();
	// Returns 'Lornsenstraße'
	$addressStreetLong = $firstResult->getAddress()->getStreetName()->getLongName();

	// Returns '43'
	$addressStreetNumberShort = $firstResult->getAddress()->getStreetNumber()->getShortName();
	// Returns '43'
	$addressStreetNumberLong = $firstResult->getAddress()->getStreetNumber()->getLongName();

	// Returns '24105'
	$addressPostalCodeShort = $firstResult->getAddress()->getPostalCode()->getShortName();
	// Returns '24105'
	$addressPostalCodeLong = $firstResult->getAddress()->getPostalCode()->getLongName();

	// Returns 'KI'
	$addressCityShort = $firstResult->getAddress()->getCity()->getShortName();
	// Returns 'Kiel'
	$addressCityLong = $firstResult->getAddress()->getCity()->getLongName();

	// Returns 'Ravensberg - Brunswik - Düsternbrook'
	$addressAreaShort = $firstResult->getAddress()->getArea()->getShortName();
	// Returns 'Ravensberg - Brunswik - Düsternbrook'
	$addressAreaLong = $firstResult->getAddress()->getArea()->getLongName();

	// Returns 'SH'
	$addressProvinceShort = $firstResult->getAddress()->getProvince()->getShortName();
	// Returns 'Schleswig-Holstein'
	$addressProvinceLong = $firstResult->getAddress()->getProvince()->getLongName();

	// Returns 'DE'
	$addressCountryShort = $firstResult->getAddress()->getCountry()->getShortName();
	// Returns 'Germany'
	$addressCountryLong = $firstResult->getAddress()->getCountry()->getLongName();

	// Retrieving the geometry information from the lookup result
	// Returns 54.334123
	$geometryLocationLatitude = $firstResult->getGeometry()->getLocation()->getLatitude();
	// Returns 10.1364007
	$geometryLocationLatitude = $firstResult->getGeometry()->getLocation()->getLongitude();

	// Returns 54.335471980291
	$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getNortheast()->getLatitude();
	// Returns 10.137749680292
	$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getNortheast()->getLongitude();
	// Returns 54.332774019708
	$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getSouthwest()->getLatitude();
	// Returns 10.135051719708
	$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getSouthwest()->getLongitude();

	// Retrieving the Google Places information from the lookup result
	// Returns 'ChIJ_zNzWmpWskcRP8DWT5eX5jQ'
	$googlePlacesId = $firstResult->getGooglePlacesId();

} catch (GoogleGeocode\Exception\NetworkException $exception) {
	// Google Geocode API is not reachable or curl failed
} catch (GoogleGeocode\Exception\ApiException $exception) {
	// Google Geocode API unexpected result
} catch (GoogleGeocode\Exception\ApiLimitException $exception) {
	// Google Geocode API requests over the allowed limit
} catch (GoogleGeocode\Exception\ApiNoResultsException $exception) {
	// Google Geocode API request had no result
}

```

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-google-geocoder/blob/master/CONTRIBUTING.md) document.**

## License

PHP Google Geocoder is under the MIT license.