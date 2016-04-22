<?php

namespace GoogleGeocode\GeoLocation;

/**
 * Class GeoLocationAddress
 *
 * @package GoogleGeocode\GeoLocation
 */
class GeoLocationAddress
{

	const RESULT_TYPE_STREET_NUMBER = 'street_number';
	const RESULT_TYPE_STREET_NAME = 'route';
	const RESULT_TYPE_POSTAL_CODE = 'postal_code';
	const RESULT_TYPE_CITY = 'locality';
	const RESULT_TYPE_AREA = 'sublocality';
	const RESULT_TYPE_PROVINCE = 'administrative_area';
	const RESULT_TYPE_COUNTRY = 'country';

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $streetNumber = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $streetName = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $city = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $postalCode = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $area = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $province = null;

	/**
	 * @var GeoLocationAddressComponent
	 */
	private $country = null;

	/**
	 * GeoLocationAddress constructor.
	 *
	 * @param array $addressData
	 */
	public function __construct(array $addressData)
	{
		for ($i = 0; $i < count($addressData); $i++) {
			for ($j = 0; $j < count($addressData[$i]['types']); $j++) {
				$componentType = $addressData[$i]['types'][$j];
				$validComponentTypes = $this->getValidTypes();
				for ($k = 0; $k < count($validComponentTypes); $k++) {
					if (strpos($componentType, $validComponentTypes[$k]) === 0) {
						$this->setResult(
							$validComponentTypes[$k],
							$addressData[$i]['short_name'],
							$addressData[$i]['long_name']
						);
						break 2;
					}
				}
			}
		}
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getStreetNumber()
	{
		return $this->streetNumber;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getStreetName()
	{
		return $this->streetName;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getPostalCode()
	{
		return $this->postalCode;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getArea()
	{
		return $this->area;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getProvince()
	{
		return $this->province;
	}

	/**
	 * @return GeoLocationAddressComponent
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @return bool
	 */
	public function hasStreetNumber()
	{
		return !is_null($this->streetNumber);
	}

	/**
	 * @return bool
	 */
	public function hasStreetName()
	{
		return !is_null($this->streetName);
	}

	/**
	 * @return bool
	 */
	public function hasCity()
	{
		return !is_null($this->city);
	}

	/**
	 * @return bool
	 */
	public function hasPostalCode()
	{
		return !is_null($this->postalCode);
	}

	/**
	 * @return bool
	 */
	public function hasArea()
	{
		return !is_null($this->area);
	}

	/**
	 * @return bool
	 */
	public function hasProvince()
	{
		return !is_null($this->province);
	}

	/**
	 * @return bool
	 */
	public function hasCountry()
	{
		return !is_null($this->country);
	}

	/**
	 * @return array
	 */
	private function getValidTypes()
	{
		return array(
			self::RESULT_TYPE_STREET_NUMBER,
			self::RESULT_TYPE_STREET_NAME,
			self::RESULT_TYPE_POSTAL_CODE,
			self::RESULT_TYPE_CITY,
			self::RESULT_TYPE_AREA,
			self::RESULT_TYPE_PROVINCE,
			self::RESULT_TYPE_COUNTRY,
		);
	}

	/**
	 * @param string $type
	 * @param string $shortName
	 * @param string $longName
	 */
	private function setResult($type, $shortName, $longName)
	{
		switch ($type) {
			case self::RESULT_TYPE_STREET_NUMBER:
				$this->streetNumber = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_STREET_NAME:
				$this->streetName = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_POSTAL_CODE:
				$this->postalCode = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_CITY:
				$this->city = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_AREA:
				$this->area = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_PROVINCE:
				$this->province = new GeoLocationAddressComponent($shortName, $longName);
				break;
			case self::RESULT_TYPE_COUNTRY:
				$this->country = new GeoLocationAddressComponent($shortName, $longName);
				break;
		}
	}

}
