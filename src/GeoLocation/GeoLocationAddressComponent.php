<?php

namespace GoogleGeocode\GeoLocation;

/**
 * Class GeoLocationAddressComponent
 *
 * @package GoogleGeocode\GeoLocation
 */
class GeoLocationAddressComponent
{

	/**
	 * @var string
	 */
	private $longName;

	/**
	 * @var string
	 */
	private $shortName;

	/**
	 * GeoLocationAddressComponent constructor.
	 *
	 * @param string $shortName
	 * @param string $longName
	 */
	public function __construct($shortName, $longName)
	{
		$this->shortName = $shortName;
		$this->longName = $longName;
	}

	/**
	 * @return string
	 */
	public function getLongName()
	{
		return $this->longName;
	}

	/**
	 * @return string
	 */
	public function getShortName()
	{
		return $this->shortName;
	}

}
