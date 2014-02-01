<?php

namespace spec\Niborb\PostcodeAPI;

use Niborb\PostcodeAPI\Address;
use Niborb\PostcodeAPI\Client\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Niborb\PostcodeAPI\Client\PostcodeAPIClient;

/**
 * Class PostcodeAPISpec
 * @package spec\Niborb\PostcodeAPI
 */
class PostcodeAPISpec extends ObjectBehavior
{
    /**
     * @var PostcodeAPIClient $client
     */
    protected $client;

    function let(PostcodeAPIClient $client)
    {
        $this->client = $client;
        $this->beConstructedWith('api', 'uri', $client);
    }


    function it_is_initializable()
    {
        $this->shouldHaveType('Niborb\PostcodeAPI\PostcodeAPI');
    }

    function it_should_return_address_information_by_given_postalcode_and_housenumber(Response $response, Address $address)
    {
        $address->getStreet()->willReturn('Wilhelminapark');
        $address->getHouseNumber('21')->willReturn('21');
        $address->getPostcode()->willReturn('5041EB');
        $address->getTown()->willReturn('Tilburg');
        $address->getLatitude()->willReturn(51.9401);
        $address->getLongitude()->willReturn(5.61531);

        $response->getAddress()->willReturn($address);
        $this->client->address('5041EB', '21')->willReturn($response);

        $this->getAddressByPostalcodeAndHouseNumber('5041EB', '21')->shouldReturnAnInstanceOf(
            'Niborb\PostcodeAPI\Address'
        );

        $this->getAddressByPostalcodeAndHouseNumber('5041EB', '21')->shouldReturn(
            $address
        );

        $this->client->address('5041EB', '21')->shouldBeCalledTimes(2);
    }

    function it_should_return_postcode_information_by_given_postalcode(Response $response, Address $address)
    {
        $address->getStreet()->willReturn('Wilhelminapark');
        $address->getPostcode()->willReturn('5041EB');
        $address->getTown()->willReturn('Tilburg');
        $address->getLatitude()->willReturn(51.9401);
        $address->getLongitude()->willReturn(5.61531);

        $response->getAddress()->willReturn($address);
        $this->client->postcode('5041EB')->willReturn($response);

        $this->getAddressByPostalcode('5041EB')->shouldReturnAnInstanceOf(
            'Niborb\PostcodeAPI\Address'
        );

        $this->getAddressByPostalcode('5041EB')->shouldReturn(
            $address
        );

        $this->client->postcode('5041EB')->shouldBeCalledTimes(2);
    }

    function it_should_return_address_information_by_latitude_and_longitude(Response $response, Address $address)
    {

        $latitude = 51.5664;
        $longitude = 5.07718;
        $address->getStreet()->willReturn('Wilhelminapark');
        $address->getPostcode()->willReturn('5041EB');
        $address->getTown()->willReturn('Tilburg');
        $address->getLatitude()->willReturn($latitude);
        $address->getLongitude()->willReturn($longitude);
        $address->getXPos()->willReturn(133504);
        $address->getYPos()->willReturn(397543);

        $response->getAddress()->willReturn($address);

        $this->client->wgs84($latitude, $longitude)->willReturn($response);

        /** @var Address $address */
        $this->getAddressByLatitudeAndLongitude($latitude, $longitude)->shouldReturn($address);

    }


}
