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

    function it_should_return_address_information_by_given_postalcode_and_housenumber(
        Response $response,
        Address $address
    ) {
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

    function it_calculates_the_distance_between_two_the_same_postcodes_should_be_zero(
        Address $addressA,
        Address $addressB,
        Response $a,
        Response $b
    ) {
        $postcodeA = '1234AB';
        $postcodeB = '5678CD';

        $addressA->getLatitude()->willReturn(51.5664);
        $addressA->getLongitude()->willReturn(5.07718);
        $addressA->distanceToAddress($addressB)->willReturn(0.0)->shouldBeCalledTimes(1);

        $addressB->getLatitude()->willReturn(51.5664);
        $addressB->getLongitude()->willReturn(5.07718);

        $a->getAddress()->willReturn($addressA);
        $b->getAddress()->willReturn($addressB);
        $this->client->postcode($postcodeA)->willReturn($a);
        $this->client->postcode($postcodeB)->willReturn($b);

        $this->getDistanceBetweenPostcodesInKM($postcodeA, $postcodeB)->shouldReturn(0.0);


    }

    function it_calculates_the_distance_between_two_different_postcodes_in_km(
        Address $addressA,
        Address $addressB,
        Response $a,
        Response $b
    ) {
        $postcodeA = '1234AB';
        $postcodeB = '5678CD';

        $addressA->getLatitude()->willReturn(52.3747157); // Amsterdam (nl)
        $addressA->getLongitude()->willReturn(4.8986182);
        $addressA->distanceToAddress($addressB)->willReturn(177.583)->shouldBeCalledTimes(1);

        $addressB->getLatitude()->willReturn(50.8577968); // Maastricht (nl)
        $addressB->getLongitude()->willReturn(5.7009038);

        $a->getAddress()->willReturn($addressA);
        $b->getAddress()->willReturn($addressB);

        $this->client->postcode($postcodeA)->willReturn($a)->shouldBeCalledTimes(1);
        $this->client->postcode($postcodeB)->willReturn($b)->shouldBeCalledTimes(1);

        $this->getDistanceBetweenPostcodesInKM($postcodeA, $postcodeB)->shouldReturn(177.583);
    }

}
