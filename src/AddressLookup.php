<?php

namespace GoogleGeocode;

/**
 * Class AddressLookup
 *
 * @package GoogleGeocode
 */
class AddressLookup extends Base\BaseLookup
{

	/**
	 * @param string $address
	 * @return $this
	 * @throws Exception\ApiException
	 * @throws Exception\ApiLimitException
	 * @throws Exception\ApiNoResultsException
	 * @throws Exception\NetworkException
	 */
	public function lookup($address)
	{
		$requestUrl = self::API_BASE_URL . $this->encodeUrlParameter($address);
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
		return '&address=' . parent::encodeUrlParameter($urlParameter);
	}

}
