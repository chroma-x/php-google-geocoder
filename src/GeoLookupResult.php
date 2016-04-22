<?php

namespace GoogleGeocode;

/**
 * Class AddressLookupResult
 *
 * @package GoogleGeocode
 */
class GeoLookupResult
{

	/**
	 * @var GeoLocation\GeoLocationAddress
	 */
	private $address = null;

	/**
	 * @var GeoLocation\GeoLocationGeometry
	 */
	private $geometry = null;

	/**
	 * @var string
	 */
	private $googlePlacesId = null;

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

	/**
	 * @return bool
	 */
	public function hasAddress()
	{
		return !is_null($this->address);
	}

	/**
	 * @return bool
	 */
	public function hasGeometry()
	{
		return !is_null($this->geometry);
	}

	/**
	 * @return bool
	 */
	public function hasGooglePlacesId()
	{
		return !is_null($this->googlePlacesId);
	}

}
