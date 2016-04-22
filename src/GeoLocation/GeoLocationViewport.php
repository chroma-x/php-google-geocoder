<?php

namespace GoogleGeocode\GeoLocation;

/**
 * Class GeoLocationViewport
 *
 * @package GoogleGeocode\GeoLocation
 */
class GeoLocationViewport
{

	/**
	 * @var GeoLocation
	 */
	private $northeast;

	/**
	 * @var GeoLocation
	 */
	private $southwest;

	/**
	 * GeoLocation constructor.
	 *
	 * @param GeoLocation $northeaset
	 * @param GeoLocation $southwest
	 */
	public function __construct($northeaset, $southwest)
	{
		$this->northeast = $northeaset;
		$this->southwest = $southwest;
	}

	/**
	 * @return GeoLocation
	 */
	public function getNortheast()
	{
		return $this->northeast;
	}

	/**
	 * @return GeoLocation
	 */
	public function getSouthwest()
	{
		return $this->southwest;
	}

}
