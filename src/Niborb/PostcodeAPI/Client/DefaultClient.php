<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 25-01-14
 */

namespace Niborb\PostcodeAPI\Client;


use Guzzle\Http\Client;
use Guzzle\Http\Message\Response as HttpResponse;

/**
 * Class DefaultClient
 * @package Niborb\PostcodeAPI\Client
 */
class DefaultClient implements PostcodeAPIClient
{
    /**
     * @var
     */
    private $apiKey;
    /**
     * @var string
     */
    private $uri;

    /**
     * @var Client
     */
    private $client;


    /**
     * @param $apiKey
     * @param string $uri
     * @throws \RuntimeException
     */
    public function __construct($apiKey, $uri = 'http://api.postcodeapi.nu/')
    {
        $this->apiKey = $apiKey;
        $this->uri = $uri;
    }

    /**
     * @param Client $client
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (!$this->client instanceof Client) {
            $this->client = new Client($this->uri);
            $this->client->setDefaultOption('headers/Api-Key', $this->apiKey);
        }

        return $this->client;
    }

    /**
     * @param string $postalCode
     * @throws \RuntimeException
     * @return Response
     */
    public function postcode($postalCode)
    {
        $response = $this->callClient($postalCode);

        return $this->createApiResponseFromHttpResponse($response);
    }

    /**
     * @param string $postalCode
     * @param string $houseNumber
     * @throws \RuntimeException
     * @return Response
     */
    public function address($postalCode, $houseNumber)
    {
        $response = $this->callClient($postalCode . '/' . $houseNumber);

        return $this->createApiResponseFromHttpResponse($response);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @throws \RuntimeException
     * @return Response
     */
    public function wgs84($latitude, $longitude)
    {
        $longitude = number_format($longitude, 10, '.', '');
        $latitude = number_format($latitude, 10, '.', '');

        $response = $this->callClient('wgs84/' . $latitude . ',' . $longitude);

        return $this->createApiResponseFromHttpResponse($response);
    }

    /**
     * @param $action
     * @return HttpResponse
     */
    private function callClient($action)
    {
        return $this->getHttpClient()->get($action)->send();
    }

    /**
     * @param HttpResponse $response
     * @return Response
     * @throws \RuntimeException
     */
    private function createApiResponseFromHttpResponse(HttpResponse $response)
    {
        if ($response->getStatusCode() != 200) {
            throw new \RuntimeException('Response code ' . $response->getStatusCode());
        }

        $jsonBody = $response->getBody(true);

        return new Response(json_decode($jsonBody, true));
    }
}