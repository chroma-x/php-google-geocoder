<?php

namespace Markenwerk\GoogleGeocode\Lookup;

use Markenwerk\CommonException;

/**
 * Class AddressLookup
 *
 * @package Markenwerk\GoogleGeocode\Lookup
 */
class AddressLookup extends AbstractLookup
{

	/**
	 * @param string $address
	 * @return $this
	 * @throws CommonException\ApiException\AuthenticationException
	 * @throws CommonException\ApiException\InvalidResponseException
	 * @throws CommonException\ApiException\NoResultException
	 * @throws CommonException\ApiException\RequestQuotaException
	 * @throws CommonException\NetworkException\CurlException
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
