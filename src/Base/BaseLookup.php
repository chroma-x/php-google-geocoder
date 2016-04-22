<?php

namespace GoogleGeocode\Base;

use GoogleGeocode;

/**
 * Class BaseLookup
 *
 * @package GoogleGeocode\Base
 */
abstract class BaseLookup
{

	const API_BASE_URL = 'https://maps.google.com/maps/api/geocode/json?sensor=false';

	/**
	 * @var GoogleGeocode\GeoLookupResult[]
	 */
	private $results = array();

	/**
	 * @param GoogleGeocode\GeoLookupResult $result
	 * @return $this
	 */
	protected function addResult(GoogleGeocode\GeoLookupResult $result)
	{
		$this->results[] = $result;
		return $this;
	}

	/**
	 * @return $this
	 */
	protected function clearResults()
	{
		$this->results = array();
		return $this;
	}

	/**
	 * @return GoogleGeocode\GeoLookupResult[]
	 */
	public function getResults()
	{
		return $this->results;
	}

	/**
	 * @return int
	 */
	public function getResultCount()
	{
		return count($this->getResults());
	}

	/**
	 * @return GoogleGeocode\GeoLookupResult
	 */
	public function getFirstResult()
	{
		if (count($this->results) == 0) {
			return null;
		}
		return $this->results[0];
	}

	/**
	 * Processes the remote request
	 *
	 * @param string
	 * @return string
	 * @throws GoogleGeocode\Exception\ApiException
	 * @throws GoogleGeocode\Exception\ApiLimitException
	 * @throws GoogleGeocode\Exception\ApiNoResultsException
	 * @throws GoogleGeocode\Exception\NetworkException
	 */
	protected function request($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		curl_close($curl);
		if (!$response) {
			throw new GoogleGeocode\Exception\NetworkException('Curling the API endpoint ' . $url . ' failed.');
		}
		$responseData = @json_decode($response, true);
		if (is_null($responseData) || !is_array($responseData) || !isset($responseData['status'])) {
			throw new GoogleGeocode\Exception\ApiException('Parsing the API response from body failed: ' . $response);
		}
		$responseStatus = mb_strtoupper($responseData['status']);
		if ($responseStatus != 'OK') {
			if ($responseStatus == 'OVER_QUERY_LIMIT') {
				$exceptionMessage = 'Google Geocoder request limit reached';
				if (isset($responseData['error_message'])) {
					$exceptionMessage .= ': ' . $responseData['error_message'];
				}
				throw new GoogleGeocode\Exception\ApiLimitException($exceptionMessage);
			} else if ($responseStatus == 'REQUEST_DENIED') {
				$exceptionMessage = 'Google Geocoder request was denied';
				if (isset($responseData['error_message'])) {
					$exceptionMessage .= ': ' . $responseData['error_message'];
				}
				throw new GoogleGeocode\Exception\ApiLimitException($exceptionMessage);
			}
			$exceptionMessage = 'Google Geocoder no results';
			if (isset($responseData['error_message'])) {
				$exceptionMessage .= ': ' . $responseData['error_message'];
			}
			throw new GoogleGeocode\Exception\ApiNoResultsException($exceptionMessage);
		}
		return $responseData;
	}

	/**
	 * @param $responseData
	 * @return $this
	 */
	protected function addResultsFromResponse($responseData)
	{
		for ($i = 0; $i < count($responseData['results']); $i++) {
			$address = $responseData['results'][$i]['address_components'];
			$geometry = $responseData['results'][$i]['geometry'];
			$placesId = $responseData['results'][$i]['place_id'];
			$locationAddress = new GoogleGeocode\GeoLocation\GeoLocationAddress($address);
			$locationGeometry = new GoogleGeocode\GeoLocation\GeoLocationGeometry($geometry);
			$this->addResult(new GoogleGeocode\GeoLookupResult($locationAddress, $locationGeometry, $placesId));
		}
		return $this;
	}

	/**
	 * Returns the address as pseudo url encoded utf8 string
	 *
	 * @param string $urlParameter
	 * @return string
	 */
	protected function encodeUrlParameter($urlParameter)
	{
		$urlParameter = str_replace(' ', '+', $urlParameter);
		return $urlParameter;
	}

}
