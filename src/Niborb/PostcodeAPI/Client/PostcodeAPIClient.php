<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 2013-2014
 * Date: 25-01-14
 */

namespace Niborb\PostcodeAPI\Client;

use Niborb\PostcodeAPI\Client\Response;

/**
 * Class PostcodeAPIClient
 * @package spec\Niborb\PostcodeAPI\Client
 */
interface PostcodeAPIClient
{

    /**
     * @param string $postalCode
     * @return Response
     */
    public function postcode($postalCode);

    /**
     * @param string $postalCode
     * @param string $houseNumber
     * @return Response
     */
    public function address($postalCode, $houseNumber);

    /**
     * @param float $latitude
     * @param float $longitude
     * @return Response
     */
    public function wgs84($latitude, $longitude);
}