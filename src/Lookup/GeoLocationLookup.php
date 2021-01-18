<?php

namespace ChromaX\GoogleGeocode\Lookup;

use ChromaX\CommonException;

/**
 * Class GeoLocationLookup
 *
 * @package ChromaX\GoogleGeocode\Lookup
 */
class GeoLocationLookup extends AbstractApiKeyGatedLookup
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
		$requestUrl = $this->addApiKey($requestUrl);
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
