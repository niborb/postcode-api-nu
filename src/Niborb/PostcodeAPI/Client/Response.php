<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 25-01-14
 */

namespace Niborb\PostcodeAPI\Client;

use Niborb\PostcodeAPI\Address;

/**
 * Class Response
 * @package Niborb\PostcodeAPI\Client
 */
class Response
{
    /**
     * @var boolean
     */
    private $success;
    /**
     * @var Address
     */
    private $address;

    /**
     * @param array $data
     * @throws \RuntimeException
     */
    public function __construct(array $data)
    {
        if (!array_key_exists('success', $data)) {
            throw new \RuntimeException('Could not find "success" element in response data');
        }

        $this->success = (bool) $data['success'];

        if ($this->success) {
            $this->readAddressFromData($data);
        }
    }

    /**
     * @param array $data
     */
    private function readAddressFromData(array $data)
    {
        $this->validateData($data);

        $this->address = new Address();
        $this->address
            ->setStreet($data['resource']['street'])
            ->setHouseNumber($data['resource']['house_number'])
            ->setPostcode($data['resource']['postcode'])
            ->setTown($data['resource']['town'])
            ->setMunicipality($data['resource']['municipality'])
            ->setProvince($data['resource']['province'])
            ->setLatitude($data['resource']['latitude'])
            ->setLongitude($data['resource']['longitude'])
            ->setXPos($data['resource']['x'])
            ->setYPos($data['resource']['y']);

    }

    /**
     * @param $data
     * @throws \RuntimeException
     */
    private function validateData(array $data)
    {
        if (!array_key_exists('resource', $data)) {
            throw new \RuntimeException('Could not find "resource" element in response data');
        }

        $requiredFields = array('street', 'postcode', 'town', 'latitude', 'longitude', 'x', 'y');

        $intersect = array_intersect_key($data['resource'], array_flip($requiredFields));

        if (count($intersect) !== count($requiredFields)) {
            throw new \RuntimeException('Not all required fields are set in the response data');
        }
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }
}