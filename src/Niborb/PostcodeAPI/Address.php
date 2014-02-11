<?php
/**
 * @author Robin Breuker
 * @copyright 2ndInterface 20013-2014
 * Date: 25-01-14
 */

namespace Niborb\PostcodeAPI;


/**
 * Class Address
 * @package Niborb\PostcodeAPI
 */
/**
 * Class Address
 * @package Niborb\PostcodeAPI
 */
class Address
{

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $houseNumber;

    /**
     * @var string
     */
    private $province;

    /**
     * @var string
     */
    private $municipality;

    /**
     * @var string postalcode ([0-9]{4}[A-Z]{2})
     */
    private $postcode;
    /**
     * @var string
     */
    private $town;
    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var float
     */
    private $xPos;
    /**
     * @var float
     */
    private $yPos;
    /**
     * @var Bag
     */
    private $bag;

    /**
     * @return \Niborb\PostcodeAPI\Bag
     */
    public function getBag()
    {
        return $this->bag;
    }

    /**
     * @param \Niborb\PostcodeAPI\Bag $bag
     *
     * @return Address
     */
    public function setBag($bag)
    {
        $this->bag = $bag;

        return $this;
    }



    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     *
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $postcode = preg_replace('/\s/u', '', $postcode);
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     *
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getXPos()
    {
        return $this->xPos;
    }

    /**
     * @param float $xPos
     *
     * @return Address
     */
    public function setXPos($xPos)
    {
        $this->xPos = $xPos;

        return $this;
    }

    /**
     * @return float
     */
    public function getYPos()
    {
        return $this->yPos;
    }

    /**
     * @param float $yPos
     *
     * @return Address
     */
    public function setYPos($yPos)
    {
        $this->yPos = $yPos;

        return $this;
    }

    /**
     * @param $houseNumber
     *
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }


    /**
     * @return string
     */
    public  function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "Street: %s %s\nPostalcode: %s\nTown: %s\nMunicipality: %s\nProvince: %s\nLatitude: %s\nLongitude: %s\n",
            $this->getStreet(),
            $this->getHouseNumber(),
            $this->getPostcode(),
            $this->getTown(),
            $this->getMunicipality(),
            $this->getProvince(),
            $this->getLatitude(),
            $this->getLongitude()
        );
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     *
     * @return Address
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param string $municipality
     *
     * @return Address
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;

        return $this;
    }


    /**
     * @param Address $addressB
     * @return float the distance in km
     */
    public function distanceToAddress(Address $addressB)
    {
        $longitudeA = $this->getLongitude();
        $latitudeA = $this->getLatitude();

        $longitudeB = $addressB->getLongitude();
        $latitudeB = $addressB->getLatitude();

        return $this->calculateDistanceInKm($longitudeA, $latitudeA, $longitudeB, $latitudeB);
    }

    /**
     * @param $longitudeA
     * @param $latitudeA
     * @param $longitudeB
     * @param $latitudeB
     * @return float
     */
    private function calculateDistanceInKm($longitudeA, $latitudeA, $longitudeB, $latitudeB)
    {
        $pi80 = M_PI / 180;
        $latitudeA *= $pi80;
        $longitudeA *= $pi80;
        $latitudeB *= $pi80;
        $longitudeB *= $pi80;

        $dlon = $longitudeB - $longitudeA;
        $dlat = $latitudeB - $latitudeA;

        $a = sin($dlat/2) * sin($dlat/2) + cos($latitudeA) * cos($latitudeB) * sin($dlon/2) * sin($dlon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $r = 6372.797; // radius of earth in KM
        $d = $r * $c;

        return round($d, 3);
    }
}
