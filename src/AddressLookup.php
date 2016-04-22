<?php

namespace GoogleGeocode;

/**
 * Class AddressLookup
 *
 * @package GoogleGeocode
 */
class AddressLookup
{

	const API_BASE_URL = 'https://maps.google.com/maps/api/geocode/json?sensor=false&address=';

	/**
	 * @var AddressLookupResult[]
	 */
	private $results = array();

	/**
	 * @param string $address
	 * @return $this
	 * @throws Exception\ApiException
	 * @throws Exception\ApiLimitException
	 * @throws Exception\ApiNoResultsException
	 * @throws Exception\NetworkException
	 */
	public function lookup($address = null)
	{
		$requestUrl = self::API_BASE_URL . $this->encodeAddress($address);
		$responseJson = $this->request($requestUrl);
		$responseData = @json_decode($responseJson, true);
		if (is_null($responseData) || !is_array($responseData) || !isset($responseData['status'])) {
			throw new Exception\ApiException('Parsing the API response failed');
		}
		$responseStatus = mb_strtoupper($responseData['status']);
		if ($responseStatus != 'OK') {
			if ($responseStatus == 'OVER_QUERY_LIMIT') {
				throw new Exception\ApiLimitException('Google Geocoder request limit reached.');
			}
			throw new Exception\ApiNoResultsException('Google Geocoder no results');
		}
		$this->results = array();
		for ($i = 0; $i < count($responseData['results']); $i++) {
			$address = $responseData['results'][$i]['address_components'];
			$geometry = $responseData['results'][$i]['geometry'];
			$placesId = $responseData['results'][$i]['place_id'];
			$locationAddress = new GeoLocation\GeoLocationAddress($address);
			$locationGeometry = new GeoLocation\GeoLocationGeometry($geometry);
			$this->results[] = new AddressLookupResult($locationAddress, $locationGeometry, $placesId);
		}
		return $this;
	}

	/**
	 * @return AddressLookupResult[]
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
	 * @return AddressLookupResult
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
	 * @throws Exception\NetworkException
	 */
	private function request($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = curl_exec($curl);
		curl_close($curl);
		if (!$response) {
			throw new Exception\NetworkException('Curling the API endpoint ' . $url . ' failed.');
		}
		return $response;
	}

	/**
	 * Returns the address as pseudo url encoded utf8 string
	 *
	 * @param string $address
	 * @return string
	 */
	private function encodeAddress($address)
	{
		$address = str_replace(' ', '+', $address);
		return $address;
	}

}
