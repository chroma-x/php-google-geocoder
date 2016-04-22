<?php

namespace GoogleGeocode\GeoLocation;

/**
 * Class GeoLocation
 *
 * @package GoogleGeocode\GeoLocation
 */
class GeoLocation
{

	/**
	 * @var float
	 */
	private $latitude;

	/**
	 * @var float
	 */
	private $longitude;

	/**
	 * GeoLocation constructor.
	 *
	 * @param float $latitude
	 * @param float $longitude
	 */
	public function __construct($latitude, $longitude)
	{
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}

}
