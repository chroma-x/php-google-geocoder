# PHP Google Geocoder

[![Build Status](https://travis-ci.org/markenwerk/php-google-geocoder.svg?branch=master)](https://travis-ci.org/markenwerk/php-google-geocoder)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-google-geocoder/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-google-geocoder/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/571f7841fcd19a004544233f/badge.svg)](https://www.versioneye.com/user/projects/571f7841fcd19a004544233f)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/504a9bdf-2d57-4977-ae52-4949443ffdbf.svg)](https://insight.sensiolabs.com/projects/504a9bdf-2d57-4977-ae52-4949443ffdbf)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-google-geocoder/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-google-geocoder)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/google-geocoder/v/stable)](https://packagist.org/packages/markenwerk/google-geocoder)
[![Total Downloads](https://poser.pugx.org/markenwerk/google-geocoder/downloads)](https://packagist.org/packages/markenwerk/google-geocoder)
[![License](https://poser.pugx.org/markenwerk/google-geocoder/license)](https://packagist.org/packages/markenwerk/google-geocoder)

A PHP library to query Google's location service for geolocation and reverse lookups based on a given address, a geo location or a Google Places ID.

## Installation

```{json}
{
   	"require": {
        "markenwerk/google-geocoder": "~3.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

---

### Performing a GeoLookup

#### Resolving an address

```{php}
use Markenwerk\CommonException;

try{
	// Perform lookup
	$addressLookup = new Markenwerk\GoogleGeocode\Lookup\AddressLookup();
	$addressLookup->lookup('Germany, 24105 Kiel, Lornsenstraße 43');

	// Retrieving the lookup as an array of Markenwerk\GoogleGeocode\Result\GeoLookupResult instances
	$lookupResults = $addressLookup->getResults();

	// Get the number of lookup results
	$lookupResultCount = $addressLookup->getResultCount();

	// Retrieving the first lookup result as Markenwerk\GoogleGeocode\Result\GeoLookupResult instance
	$firstResult = $addressLookup->getFirstResult();

} catch (CommonException\NetworkException\CurlException $exception) {
	// Google Geocode API is not reachable or curl failed
} catch (CommonException\ApiException\InvalidResponseException $exception) {
	// Google Geocode API unexpected result
} catch (CommonException\ApiException\RequestQuotaException $exception) {
	// Google Geocode API requests over the allowed limit
} catch (CommonException\ApiException\NoResultException $exception) {
	// Google Geocode API request had no result
}

```

#### Resolving a geo location

```{php}
use Markenwerk\CommonException;

try{
	// Perform lookup
	$geoLocationLookup = new Markenwerk\GoogleGeocode\Lookup\GeoLocationLookup();
	$geoLocationLookup->lookup(54.334123, 10.1364007);

	// Retrieving the lookup as an array of Markenwerk\GoogleGeocode\Result\GeoLookupResult instances
	$lookupResults = $geoLocationLookup->getResults();

	// Get the number of lookup results
	$lookupResultCount = $geoLocationLookup->getResultCount();

	// Retrieving the first lookup result as Markenwerk\GoogleGeocode\Result\AddressLookupResult instance
	$firstResult = $geoLocationLookup->getFirstResult();

} catch (CommonException\NetworkException\CurlException $exception) {
	// Google Geocode API is not reachable or curl failed
} catch (CommonException\ApiException\InvalidResponseException $exception) {
	// Google Geocode API unexpected result
} catch (CommonException\ApiException\RequestQuotaException $exception) {
	// Google Geocode API requests over the allowed limit
} catch (CommonException\ApiException\NoResultException $exception) {
	// Google Geocode API request had no result
}

```

#### Resolving a Google Places ID

Resolving Google Places IDs utilizes the Google Places API. Therefore a Places API key is mandatory for performing a lookup. Please visit the [Google API console](https://console.developers.google.com/apis/api/geocoding_backend?project=_) to receive an API key.

```{php}
use Markenwerk\CommonException;

try{
	// Perform lookup
	$googlePlacesLookup = new Markenwerk\GoogleGeocode\Lookup\GooglePlacesLookup();
	$googlePlacesLookup
		->setApiKey('MY_GOOGLE_PLACES_API_KEY')
		->lookup('ChIJ_zNzWmpWskcRP8DWT5eX5jQ');

	// Retrieving the lookup as an array of Markenwerk\GoogleGeocode\Result\GeoLookupResult instances
	$lookupResults = $googlePlacesLookup->getResults();

	// Get the number of lookup results
	$lookupResultCount = $googlePlacesLookup->getResultCount();

	// Retrieving the first lookup result as Markenwerk\GoogleGeocode\Result\AddressLookupResult instance
	$firstResult = $googlePlacesLookup->getFirstResult();

} catch (CommonException\NetworkException\CurlException $exception) {
	// Google Geocode API is not reachable or curl failed
} catch (CommonException\ApiException\InvalidResponseException $exception) {
	// Google Geocode API unexpected result
} catch (CommonException\ApiException\RequestQuotaException $exception) {
	// Google Geocode API requests over the allowed limit
} catch (CommonException\ApiException\AuthenticationException $exception) {
	// Google Places service API key invalid
} catch (CommonException\ApiException\NoResultException $exception) {
	// Google Geocode API request had no result
}

```

---

### Reading from a GeoLookupResult

**Attention:** Plaese note that all getter methods on the `GeoLocationAddress` return a `GeoLocationAddressComponent` instance or `null`. For preventing calls on non-objects the `GeoLocationAddress` class provides methods to check whether the address components exists. 

```{php}
// Retrieving the first lookup result as Markenwerk\GoogleGeocode\Result\GeoLookupResult instance
$firstResult = $addressLookup->getFirstResult();

// Retieving address information as Markenwerk\GoogleGeocode\GeoLocation\GeoLocationAddress
$geoLocationAddress = $firstResult->getAddress();

if($firstResult->hasAddress()) {

	// Retrieving the address information from the lookup result

	if($firstResult->getAddress()->hasStreetName()) {
		// Returns 'Lornsenstraße'
		$addressStreetShort = $firstResult->getAddress()->getStreetName()->getShortName();
		// Returns 'Lornsenstraße'
		$addressStreetLong = $firstResult->getAddress()->getStreetName()->getLongName();
	}

	if($firstResult->getAddress()->hasStreetNumber()) {
		// Returns '43'
		$addressStreetNumberShort = $firstResult->getAddress()->getStreetNumber()->getShortName();
		// Returns '43'
		$addressStreetNumberLong = $firstResult->getAddress()->getStreetNumber()->getLongName();
	}

	if($firstResult->getAddress()->hasPostalCode()) {
		// Returns '24105'
		$addressPostalCodeShort = $firstResult->getAddress()->getPostalCode()->getShortName();
		// Returns '24105'
		$addressPostalCodeLong = $firstResult->getAddress()->getPostalCode()->getLongName();
	}

	if($firstResult->getAddress()->hasCity()) {
		// Returns 'KI'
		$addressCityShort = $firstResult->getAddress()->getCity()->getShortName();
		// Returns 'Kiel'
		$addressCityLong = $firstResult->getAddress()->getCity()->getLongName();
	}

	if($firstResult->getAddress()->hasArea()) {
		// Returns 'Ravensberg - Brunswik - Düsternbrook'
		$addressAreaShort = $firstResult->getAddress()->getArea()->getShortName();
		// Returns 'Ravensberg - Brunswik - Düsternbrook'
		$addressAreaLong = $firstResult->getAddress()->getArea()->getLongName();
	}

	if($firstResult->getAddress()->hasProvince()) {
		// Returns 'SH'
		$addressProvinceShort = $firstResult->getAddress()->getProvince()->getShortName();
		// Returns 'Schleswig-Holstein'
		$addressProvinceLong = $firstResult->getAddress()->getProvince()->getLongName();
	}

	if($firstResult->getAddress()->hasCountry()) {
		// Returns 'DE'
		$addressCountryShort = $firstResult->getAddress()->getCountry()->getShortName();
		// Returns 'Germany'
		$addressCountryLong = $firstResult->getAddress()->getCountry()->getLongName();
	}

}

if($firstResult->hasGeometry()) {

	// Retrieving the geometry information from the lookup result

	if($firstResult->getGeometry()->hasLocation()) {
		// Returns 54.334123
		$geometryLocationLatitude = $firstResult->getGeometry()->getLocation()->getLatitude();
		// Returns 10.1364007
		$geometryLocationLatitude = $firstResult->getGeometry()->getLocation()->getLongitude();
	}

	if($firstResult->getGeometry()->hasViewport()) {
		// Returns 54.335471980291
		$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getNortheast()->getLatitude();
		// Returns 10.137749680292
		$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getNortheast()->getLongitude();
		// Returns 54.332774019708
		$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getSouthwest()->getLatitude();
		// Returns 10.135051719708
		$geometryLocationLatitude = $firstResult->getGeometry()->getViewport()->getSouthwest()->getLongitude();
	}

}

if($firstResult->hasGooglePlacesId()) {
	// Retrieving the Google Places information from the lookup result
	// Returns 'ChIJ_zNzWmpWskcRP8DWT5eX5jQ'
	$googlePlacesId = $firstResult->getGooglePlacesId();
}
```

## Exception handling

PHP Google Geocoder provides different exceptions provided by the PHP Common Exceptions project for proper handling.  
You can find more information about [PHP Common Exceptions at Github](https://github.com/markenwerk/php-common-exceptions).

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-google-geocoder/blob/master/CONTRIBUTING.md) document.**

## License

PHP Google Geocoder is under the MIT license.
