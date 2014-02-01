<?php

namespace spec\Niborb\PostcodeAPI\Client;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class DefaultClientSpec
 * @package spec\Niborb\PostcodeAPI\Client
 *
 */
class DefaultClientSpec extends ObjectBehavior
{
    protected $client;

    function let(Client $client)
    {
        $this->beConstructedWith('api', 'uri');
        $this->client = $client;
        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Niborb\PostcodeAPI\Client\DefaultClient');
    }

    function it_should_return_address_information(Response $response, Request $request)
    {
        $postalCode = '5041EB';
        $houseNumber = '21';

        $this->client->get($postalCode . '/' . $houseNumber)->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->getBody(true)->willReturn(
            '{"success":true,"resource":{"street":"Wilhelminapark",
            "house_number":21,
            "postcode":"5041EB",
            "town":"Tilburg",
            "municipality":"Tilburg",
            "province":"Noord-Brabant",
            "latitude":51.9401,
            "longitude":5.61531,
            "x":133504,
            "y":397543}}'
        );
        $request->send()->willReturn($response);

        $this->address($postalCode, $houseNumber)->shouldReturnAnInstanceOf('Niborb\PostcodeAPI\Client\Response');
        $response = $this->address($postalCode, $houseNumber);

        $address = $response->getAddress();
        $address->getStreet()->shouldReturn('Wilhelminapark');
        $address->getHouseNumber()->shouldReturn(21);
        $address->getPostcode()->shouldReturn('5041EB');
        $address->getTown()->shouldReturn('Tilburg');
        $address->getMunicipality()->shouldReturn('Tilburg');
        $address->getProvince()->shouldReturn('Noord-Brabant');
        $address->getLatitude()->shouldReturn(51.9401);
        $address->getLongitude()->shouldReturn(5.61531);
        $address->getXPos()->shouldReturn(133504);
        $address->getYPos()->shouldReturn(397543);
    }

    function it_should_return_postcode_information(Response $response, Request $request)
    {
        $postalCode = '5041EB';

        $this->client->get($postalCode)->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->getBody(true)->willReturn(
            '{"success":true,"resource":{"street":"Wilhelminapark",
            "house_number":21,
            "postcode":"5041EB",
            "town":"Tilburg",
            "municipality":"Tilburg",
            "province":"Noord-Brabant",
            "latitude":51.9401,
            "longitude":5.61531,
            "x":133504,
            "y":397543}}'
        );
        $request->send()->willReturn($response);

        //->send()->willReturn($response);


        $this->postcode($postalCode)->shouldReturnAnInstanceOf('Niborb\PostcodeAPI\Client\Response');
        $response = $this->postcode($postalCode);

        $address = $response->getAddress();
        $address->getStreet()->shouldReturn('Wilhelminapark');
        $address->getHouseNumber()->shouldReturn(21);
        $address->getPostcode()->shouldReturn('5041EB');
        $address->getTown()->shouldReturn('Tilburg');
        $address->getLatitude()->shouldReturn(51.9401);
        $address->getLongitude()->shouldReturn(5.61531);
        $address->getXPos()->shouldReturn(133504);
        $address->getYPos()->shouldReturn(397543);
    }


    function it_should_return_wgs84_information(Response $response, Request $request)
    {
        // mocks
        $request->send()->willReturn($response);
        $this->client->get(Argument::any())->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->getBody(true)->willReturn(
            '{"success":true,"resource":{"street":"Wilhelminapark",
            "house_number":21,
            "postcode":"5041EB",
            "town":"Tilburg",
            "municipality":"Tilburg",
            "province":"Noord-Brabant",
            "latitude":51.9401,
            "longitude":5.61531,
            "x":133504,
            "y":397543}}'
        );

        $latitude = 51.5664;
        $longitude = 5.07718;
        $this->wgs84($latitude, $longitude)->shouldReturnAnInstanceOf('Niborb\PostcodeAPI\Client\Response');
    }

    function it_should_return_null_address_if_response_is_not_successful(Response $response, Request $request)
    {
        $postalCode = '5041EB';
        $houseNumber = '21';

        $this->client->get($postalCode . '/' . $houseNumber)->willReturn($request);
        $response->getStatusCode()->willReturn(200);
        $response->getBody(true)->willReturn(
            '{"success":false}'
        );
        $request->send()->willReturn($response);

        $this->address($postalCode, $houseNumber)->shouldReturnAnInstanceOf('Niborb\PostcodeAPI\Client\Response');
        $response = $this->address($postalCode, $houseNumber);
        $response->getAddress()->shouldReturn(null);

    }

    function it_should_throw_an_exception_if_responsecode_is_not_200(Response $response, Request $request)
    {
        $postalCode = '5041EB';
        $houseNumber = '21';

        $this->client->get($postalCode . '/' . $houseNumber)->willReturn($request);
        $response->getStatusCode()->willReturn(500);
        $response->getBody(true)->willReturn(
            '{"success":false}'
        );
        $request->send()->willReturn($response);

        $this->shouldThrow('\RuntimeException')->duringAddress($postalCode, $houseNumber);

    }
}
