<?php

namespace GoogleGeocode;

/**
 * Class GooglePlacesLookupTest
 *
 * @package GoogleGeocode
 */
class GooglePlacesLookupTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var string
	 */
	private $googlePlacesApiKey;

	/**
	 * GooglePlacesLookupTest constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// Receive the Google Places API key from env
		$this->googlePlacesApiKey = getenv('GOOGLE_PLACES_API_KEY');
		fwrite(STDOUT, PHP_EOL . 'Using Google Places API key ' . $this->googlePlacesApiKey . PHP_EOL);
	}

	public function testLookupSuccess()
	{
		// Perform lookup
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey($this->googlePlacesApiKey)
			->lookup('ChIJ_zNzWmpWskcRP8DWT5eX5jQ');

		// Validate results
		$this->assertEquals(1, $googlePlacesLookup->getResultCount());
		$firstResult = $googlePlacesLookup->getFirstResult();
		$this->assertInstanceOf('GoogleGeocode\\GeoLookupResult', $firstResult);

		// Address result
		$addressResult = $firstResult->getAddress();
		$this->assertEquals('43', $addressResult->getStreetNumber()->getShortName());
		$this->assertEquals('43', $addressResult->getStreetNumber()->getLongName());
		$this->assertEquals('Lornsenstraße', $addressResult->getStreetName()->getShortName());
		$this->assertEquals('Lornsenstraße', $addressResult->getStreetName()->getLongName());
		$this->assertEquals('KI', $addressResult->getCity()->getShortName());
		$this->assertEquals('Kiel', $addressResult->getCity()->getLongName());
		$this->assertEquals('24105', $addressResult->getPostalCode()->getShortName());
		$this->assertEquals('24105', $addressResult->getPostalCode()->getLongName());
		$this->assertEquals('Ravensberg - Brunswik - Düsternbrook', $addressResult->getArea()->getShortName());
		$this->assertEquals('Ravensberg - Brunswik - Düsternbrook', $addressResult->getArea()->getLongName());
		$this->assertEquals('SH', $addressResult->getProvince()->getShortName());
		$this->assertEquals('Schleswig-Holstein', $addressResult->getProvince()->getLongName());
		$this->assertEquals('DE', $addressResult->getCountry()->getShortName());
		$this->assertEquals('Germany', $addressResult->getCountry()->getLongName());

		// Geometry result
		$geometryResult = $firstResult->getGeometry();
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getLocation()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getLocation()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getLocation()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getLocation()->getLongitude());
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getViewport()->getNortheast()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getViewport()->getNortheast()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getViewport()->getNortheast()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getViewport()->getNortheast()->getLongitude());
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getViewport()->getSouthwest()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getViewport()->getSouthwest()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getViewport()->getSouthwest()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getViewport()->getSouthwest()->getLongitude());

		// Google Places ID
		$this->assertEquals('ChIJ_zNzWmpWskcRP8DWT5eX5jQ', $firstResult->getGooglePlacesId());
	}

	public function testLookupNoResults()
	{
		$this->setExpectedException(get_class(new Exception\ApiNoResultsException()));
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey($this->googlePlacesApiKey)
			->lookup('NO_VALID_PLACES_ID');
	}

	public function testLookupApiKey()
	{
		$this->setExpectedException(get_class(new Exception\ApiException()));
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey('INVALID_API_KEY')
			->lookup('ChIJ_zNzWmpWskcRP8DWT5eX5jQ');
	}

}
