<?php

namespace ChromaX\GoogleGeocode\Lookup;

use ChromaX\CommonException;

/**
 * Class GooglePlacesLookup
 *
 * @package ChromaX\GoogleGeocode\Lookup
 */
class GooglePlacesLookup extends AbstractApiKeyGatedLookup
{

	/**
	 * @param string $googlePlacesId
	 * @return $this
	 * @throws CommonException\ApiException\AuthenticationException
	 * @throws CommonException\ApiException\InvalidResponseException
	 * @throws CommonException\ApiException\NoResultException
	 * @throws CommonException\ApiException\RequestQuotaException
	 * @throws CommonException\NetworkException\CurlException
	 */
	public function lookup($googlePlacesId)
	{
		$requestUrl = self::API_BASE_URL . $this->encodeUrlParameter($googlePlacesId);
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
		return '&place_id=' . parent::encodeUrlParameter($urlParameter);
	}

}
