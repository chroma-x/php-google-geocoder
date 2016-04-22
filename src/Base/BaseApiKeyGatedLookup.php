<?php

namespace GoogleGeocode\Base;

use GoogleGeocode;

/**
 * Class BaseApiKeyGatedLookup
 *
 * @package GoogleGeocode\Base
 */
abstract class BaseApiKeyGatedLookup extends BaseLookup
{

	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @param string $apiKey
	 * @return $this
	 */
	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * Adds the API key to the URL
	 *
	 * @param string $url
	 * @return string
	 */
	protected function addApiKey($url)
	{
		return $url . '&key=' . $this->getApiKey();
	}

}
