<?php

namespace spec\Niborb\PostcodeAPI;

use Niborb\PostcodeAPI\Bag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Niborb\PostcodeAPI\Address;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Niborb\PostcodeAPI\Address');
    }

    function it_should_be_able_to_set_street()
    {
        $this->setStreet('Wilhelminapark')->getStreet()->shouldReturn('Wilhelminapark');

    }

    function it_should_be_able_to_set_postcode_and_ignore_empty_spaces()
    {
        $this->setPostcode('5041 EB')->getPostcode()->shouldReturn('5041EB');
    }

    function it_should_be_able_to_set_town()
    {
        $this->setTown('Tilburg')->getTown()->shouldReturn('Tilburg');
    }

    function it_should_be_able_to_set_latitude()
    {
        $this->setLatitude(51.9401)->getLatitude()->shouldReturn(51.9401);
    }

    function it_should_be_able_to_set_longitude()
    {
        $this->setLongitude(5.61531)->getLongitude()->shouldReturn(5.61531);
    }

    function it_should_be_able_to_set_bag(Bag $bag)
    {
        $this->setBag($bag)->getBag()->shouldReturn($bag);
    }

    function it_should_be_able_to_set_province()
    {
        $this->setProvince('Noord-Brabant')->getProvince()->shouldReturn('Noord-Brabant');
    }

    function it_should_be_able_to_set_municipality()
    {
        $this->setMunicipality('Tilburg')->getMunicipality()->shouldReturn('Tilburg');
    }

    function it_calculates_the_distance_to_another_address(Address $b)
    {
        $this->setLatitude(52.3747157);
        $this->setLongitude(4.8986182);
        $b->getLatitude()->willReturn(50.8577968);
        $b->getLongitude()->willReturn(5.7009038);

        $this->distanceToAddress($b)->shouldReturn(177.583);
    }

    function it_should_be_stringable()
    {
        $string = ' ' . $this->getWrappedObject();
        //$this->__toString()->shouldBeCalled();
    }
}
