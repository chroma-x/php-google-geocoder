<?php

namespace Markenwerk\GoogleGeocode\Lookup;

use Markenwerk\CommonException;

/**
 * Class GeoLocationLookup
 *
 * @package Markenwerk\GoogleGeocode\Lookup
 */
class GeoLocationLookup extends AbstractLookup
{

	/**
	 * @param float $latitude
	 * @param float $longitude
	 * @return $this
	 * @throws CommonException\ApiException\AuthenticationException
	 * @throws CommonException\ApiException\InvalidResponseException
	 * @throws CommonException\ApiException\NoResultException
	 * @throws CommonException\ApiException\RequestQuotaException
	 * @throws CommonException\NetworkException\CurlException
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
