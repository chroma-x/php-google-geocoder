<?php

namespace GoogleGeocode;

/**
 * Class AddressLookupResult
 *
 * @package GoogleGeocode
 */
class AddressLookupResult
{

	/**
	 * @var GeoLocation\GeoLocationAddress
	 */
	private $address;

	/**
	 * @var GeoLocation\GeoLocationGeometry
	 */
	private $geometry;

	/**
	 * @var string
	 */
	private $googlePlacesId;

	/**
	 * GeoLocation constructor.
	 *
	 * @param GeoLocation\GeoLocationAddress $address
	 * @param GeoLocation\GeoLocationGeometry $geometry
	 * @param string $googlePlacesId
	 */
	public function __construct(GeoLocation\GeoLocationAddress $address, GeoLocation\GeoLocationGeometry $geometry, $googlePlacesId)
	{
		$this->address = $address;
		$this->geometry = $geometry;
		$this->googlePlacesId = $googlePlacesId;
	}

	/**
	 * @return GeoLocation\GeoLocationAddress
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @return GeoLocation\GeoLocationGeometry
	 */
	public function getGeometry()
	{
		return $this->geometry;
	}

	/**
	 * @return string
	 */
	public function getGooglePlacesId()
	{
		return $this->googlePlacesId;
	}

}
