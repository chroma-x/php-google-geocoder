<?php

namespace GoogleGeocode;

/**
 * Class GooglePlacesLookup
 *
 * @package GoogleGeocode
 */
class GooglePlacesLookup extends Base\BaseApiKeyGatedLookup
{

	/**
	 * @param string $googlePlacesId
	 * @return $this
	 * @throws Exception\ApiException
	 * @throws Exception\ApiLimitException
	 * @throws Exception\ApiNoResultsException
	 * @throws Exception\NetworkException
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
