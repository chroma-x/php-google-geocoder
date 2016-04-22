<?php

namespace GoogleGeocode;

/**
 * Class GeoLocationLookup
 *
 * @package GoogleGeocode
 */
class GeoLocationLookup extends Base\BaseLookup
{

	/**
	 * @param float $latitude
	 * @param float $longitude
	 * @return $this
	 * @throws Exception\ApiException
	 * @throws Exception\ApiLimitException
	 * @throws Exception\ApiNoResultsException
	 * @throws Exception\NetworkException
	 */
	public function lookup($latitude, $longitude)
	{
		$requestUrl = self::API_BASE_URL . $this->encodeUrlParameter($latitude . ',' . $longitude);
		$responseData = $this->request($requestUrl);
		$this->clearResults();
		for ($i = 0; $i < count($responseData['results']); $i++) {
			$address = $responseData['results'][$i]['address_components'];
			$geometry = $responseData['results'][$i]['geometry'];
			$placesId = $responseData['results'][$i]['place_id'];
			$locationAddress = new GeoLocation\GeoLocationAddress($address);
			$locationGeometry = new GeoLocation\GeoLocationGeometry($geometry);
			$this->addResult(new GeoLookupResult($locationAddress, $locationGeometry, $placesId));
		}
		return $this;
	}

	/**
	 * @param string $urlParameter
	 * @return string
	 */
	protected function encodeUrlParameter($urlParameter)
	{
		return '&latlng=' . parent::encodeUrlParameter($urlParameter);
	}

}
