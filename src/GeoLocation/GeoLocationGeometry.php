<?php

namespace GoogleGeocode\GeoLocation;

/**
 * Class GeoLocationGeometry
 *
 * @package GoogleGeocode\GeoLocation
 */
class GeoLocationGeometry
{

	/**
	 * @var GeoLocation
	 */
	private $location = null;

	/**
	 * @var GeoLocationViewport
	 */
	private $viewport = null;

	/**
	 * GeoLocationGeometry constructor.
	 *
	 * @param array $geometryData
	 */
	public function __construct(array $geometryData)
	{
		$this->location = new GeoLocation($geometryData['location']['lat'], $geometryData['location']['lng']);
		$this->viewport = new GeoLocationViewport(
			new GeoLocation(
				$geometryData['viewport']['northeast']['lat'],
				$geometryData['viewport']['northeast']['lng']
			),
			new GeoLocation(
				$geometryData['viewport']['southwest']['lat'],
				$geometryData['viewport']['southwest']['lng']
			)
		);
	}

	/**
	 * @return GeoLocation
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * @return GeoLocationViewport
	 */
	public function getViewport()
	{
		return $this->viewport;
	}

	/**
	 * @return bool
	 */
	public function hasLocation()
	{
		return !is_null($this->location);
	}

	/**
	 * @return bool
	 */
	public function hasViewport()
	{
		return !is_null($this->viewport);
	}

}
