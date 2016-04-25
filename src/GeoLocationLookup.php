<?php

namespace GoogleGeocode;

use CommonException;

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
	 * @throws CommonException\ApiException\ApiException
	 * @throws CommonException\ApiException\ApiLimitException
	 * @throws CommonException\ApiException\ApiNoResultsException
	 * @throws CommonException\ApiException\NetworkException
	 */
	public function lookup($latitude, $longitude)
	{
		$requestUrl = self::API_BASE_URL . $this->encodeUrlParameter($latitude . ',' . $longitude);
		$responseData = $this->request($requestUrl);
		$this
			->clearResults()
			->addResultsFromResponse($responseData);
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
