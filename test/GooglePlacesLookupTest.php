<?php

namespace Markenwerk\GoogleGeocode\Lookup;

use Markenwerk\CommonException;

/**
 * Class GooglePlacesLookupTest
 *
 * @package Markenwerk\GoogleGeocode
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
	}

	public function testLookupSuccess()
	{
		if($this->googlePlacesApiKey === false){
			$this->markTestSkipped('Google Places lookup test was skipped. No API key found.');
		}

		// Perform lookup
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey($this->googlePlacesApiKey)
			->lookup('ChIJ_zNzWmpWskcRP8DWT5eX5jQ');

		// Validate results
		$this->assertEquals(1, $googlePlacesLookup->getResultCount());
		$firstResult = $googlePlacesLookup->getFirstResult();
		$this->assertInstanceOf('Markenwerk\\GoogleGeocode\\Result\\GeoLookupResult', $firstResult);

		// Address result
		$this->assertTrue($firstResult->hasAddress());
		$addressResult = $firstResult->getAddress();
		$this->assertTrue($addressResult->hasStreetNumber());
		$this->assertEquals('43', $addressResult->getStreetNumber()->getShortName());
		$this->assertEquals('43', $addressResult->getStreetNumber()->getLongName());
		$this->assertTrue($addressResult->hasStreetName());
		$this->assertEquals('Lornsenstraße', $addressResult->getStreetName()->getShortName());
		$this->assertEquals('Lornsenstraße', $addressResult->getStreetName()->getLongName());
		$this->assertTrue($addressResult->hasCity());
		$this->assertEquals('KI', $addressResult->getCity()->getShortName());
		$this->assertEquals('Kiel', $addressResult->getCity()->getLongName());
		$this->assertTrue($addressResult->hasPostalCode());
		$this->assertEquals('24105', $addressResult->getPostalCode()->getShortName());
		$this->assertEquals('24105', $addressResult->getPostalCode()->getLongName());
		$this->assertTrue($addressResult->hasArea());
		$this->assertEquals('Ravensberg - Brunswik - Düsternbrook', $addressResult->getArea()->getShortName());
		$this->assertEquals('Ravensberg - Brunswik - Düsternbrook', $addressResult->getArea()->getLongName());
		$this->assertTrue($addressResult->hasProvince());
		$this->assertEquals('SH', $addressResult->getProvince()->getShortName());
		$this->assertEquals('Schleswig-Holstein', $addressResult->getProvince()->getLongName());
		$this->assertTrue($addressResult->hasCountry());
		$this->assertEquals('DE', $addressResult->getCountry()->getShortName());
		$this->assertEquals('Germany', $addressResult->getCountry()->getLongName());

		// Geometry result
		$this->assertTrue($firstResult->hasGeometry());
		$geometryResult = $firstResult->getGeometry();
		$this->assertTrue($geometryResult->hasLocation());
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getLocation()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getLocation()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getLocation()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getLocation()->getLongitude());
		$this->assertTrue($geometryResult->hasViewport());
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getViewport()->getNortheast()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getViewport()->getNortheast()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getViewport()->getNortheast()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getViewport()->getNortheast()->getLongitude());
		$this->assertGreaterThanOrEqual(54.3, $geometryResult->getViewport()->getSouthwest()->getLatitude());
		$this->assertLessThanOrEqual(54.4, $geometryResult->getViewport()->getSouthwest()->getLatitude());
		$this->assertGreaterThanOrEqual(10.1, $geometryResult->getViewport()->getSouthwest()->getLongitude());
		$this->assertLessThanOrEqual(10.2, $geometryResult->getViewport()->getSouthwest()->getLongitude());
		$this->assertFalse($geometryResult->hasAccessPoints());

		// Google Places ID
		$this->assertTrue($firstResult->hasGooglePlacesId());
		$this->assertEquals('ChIJ_zNzWmpWskcRP8DWT5eX5jQ', $firstResult->getGooglePlacesId());
	}

	public function testLookupNoResults()
	{
		if($this->googlePlacesApiKey === false){
			$this->markTestSkipped('Google Places lookup without results test was skipped. No API key found.');
		}
		$this->setExpectedException(get_class(new CommonException\ApiException\NoResultException()));
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey($this->googlePlacesApiKey)
			->lookup('NO_VALID_PLACES_ID');
	}

	public function testLookupApiKey()
	{
		$this->setExpectedException(get_class(new CommonException\ApiException\AuthenticationException()));
		$googlePlacesLookup = new GooglePlacesLookup();
		$googlePlacesLookup
			->setApiKey('INVALID_API_KEY')
			->lookup('ChIJ_zNzWmpWskcRP8DWT5eX5jQ');
	}

}
