<?php

namespace Niborb\PostcodeAPI;

use Niborb\PostcodeAPI\Client\DefaultClient;
use Niborb\PostcodeAPI\Client\PostcodeAPIClient;
use Niborb\PostcodeAPI\Client\Response;

/**
 * Class PostcodeAPI
 * @package Niborb\PostcodeAPI
 */
class PostcodeAPI
{
    /**
     * @var Client\PostcodeAPIClient
     */
    private $client;

    /**
     * @param string $apiKey
     * @param string $uri
     * @param PostcodeAPIClient $client
     */
    public function __construct($apiKey, $uri = 'http://api.postcodeapi.nu/', PostcodeAPIClient $client = null)
    {
        if (null === $client) {
            $client = new DefaultClient($apiKey, $uri);
        }
        $this->client = $client;
    }


    /**
     * @param $postalCode
     * @param $houseNumber
     * @throws \LogicException
     * @return Address
     */
    public function getAddressByPostalcodeAndHouseNumber($postalCode, $houseNumber)
    {
        $response = $this->client->address($postalCode, $houseNumber);

        if (!$response instanceof Response) {
            throw new \LogicException('Client::address should return instanceof Response');
        }

        return $this->getAddressFromResponse($response);
    }


    /**
     * @param $postalCode
     * @throws \LogicException
     * @return Address
     */
    public function getAddressByPostalcode($postalCode)
    {
        $response = $this->client->postcode($postalCode);

        if (!$response instanceof Response) {
            throw new \LogicException('Client::postcode should return instanceof Response');
        }

        return $this->getAddressFromResponse($response);
    }

    /**
     * @param Response $response
     * @return Address
     * @throws \LogicException
     */
    private function getAddressFromResponse(Response $response)
    {
        $address = $response->getAddress();

        if (!$address instanceof Address) {
            throw new \LogicException('Response::getAddress should return instanceof Address');
        }

        return $address;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return \Niborb\PostcodeAPI\Address
     * @throws \LogicException
     */
    public function getAddressByLatitudeAndLongitude($latitude, $longitude)
    {
        $response = $this->client->wgs84($latitude, $longitude);

        if (!$response instanceof Response) {
            throw new \LogicException('Client::wsg84 should return instanceof Response');
        }

        return $this->getAddressFromResponse($response);
    }

    /**
     * calculates the distance in KM between postcodeA and postcodeB
     *
     * @param string $postcodeA
     * @param string $postcodeB
     *
     * @return float
     */
    public function getDistanceBetweenPostcodesInKM($postcodeA, $postcodeB)
    {
        $addressA = $this->client->postcode($postcodeA)->getAddress();
        $addressB = $this->client->postcode($postcodeB)->getAddress();

        return $addressA->distanceToAddress($addressB);
    }


}
