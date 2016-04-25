<?php

namespace GoogleGeocode\Base;

use CommonException;
use GoogleGeocode;
use GoogleDataStructure;

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
	 * @throws CommonException\ApiException\ApiException
	 * @throws CommonException\ApiException\ApiLimitException
	 * @throws CommonException\ApiException\ApiNoResultsException
	 * @throws CommonException\ApiException\NetworkException
	 */
	protected function request($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		curl_close($curl);
		if (!$response) {
			throw new CommonException\ApiException\NetworkException('Curling the API endpoint ' . $url . ' failed.');
		}
		$responseData = @json_decode($response, true);
		$this->validateResponse($response, $responseData);
		return $responseData;
	}

	/**
	 * @param string $rawResponse
	 * @param array|string $responseData
	 * @throws CommonException\ApiException\ApiException
	 * @throws CommonException\ApiException\ApiLimitException
	 * @throws CommonException\ApiException\ApiNoResultsException
	 */
	private function validateResponse($rawResponse, $responseData)
	{
		if (is_null($responseData) || !is_array($responseData) || !isset($responseData['status'])) {
			throw new CommonException\ApiException\ApiException('Parsing the API response from body failed: ' . $rawResponse);
		}

		$responseStatus = mb_strtoupper($responseData['status']);
		if ($responseStatus == 'OVER_QUERY_LIMIT') {
			$exceptionMessage = $this->buildExceptionMessage('Google Geocoder request limit reached', $responseData);
			throw new CommonException\ApiException\ApiLimitException($exceptionMessage);
		} else if ($responseStatus == 'REQUEST_DENIED') {
			$exceptionMessage = $this->buildExceptionMessage('Google Geocoder request was denied', $responseData);
			throw new CommonException\ApiException\ApiException($exceptionMessage);
		} else if ($responseStatus != 'OK') {
			$exceptionMessage = $this->buildExceptionMessage('Google Geocoder no results', $responseData);
			throw new CommonException\ApiException\ApiNoResultsException($exceptionMessage);
		}
	}

	/**
	 * @param string $exceptionMessage
	 * @param array $responseData
	 * @return string
	 */
	private function buildExceptionMessage($exceptionMessage, array $responseData)
	{
		if (isset($responseData['error_message'])) {
			$exceptionMessage .= ': ' . $responseData['error_message'];
		}
		return $exceptionMessage;
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
			$locationAddress = new GoogleDataStructure\GeoLocation\GeoLocationAddress();
			$locationAddress->setFromServiceResult($address);
			$locationGeometry = new GoogleDataStructure\GeoLocation\GeoLocationGeometry();
			$locationGeometry->setFromServiceResult($geometry);
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
