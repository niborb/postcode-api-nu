<?php

namespace spec\Niborb\PostcodeAPI;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BagSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Niborb\PostcodeAPI\Bag');
    }

    function it_should_be_able_to_set_id()
    {
        $this->setId('1234')->getId()->shouldReturn('1234');
    }

    function it_should_be_able_to_set_type()
    {
        $this->setType('abcd')->getType()->shouldReturn('abcd');
    }

    function it_should_be_able_to_set_purpose()
    {
        $this->setPurpose('purpose')->getPurpose()->shouldReturn('purpose');
    }
}
