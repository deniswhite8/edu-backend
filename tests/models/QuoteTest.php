<?php

namespace Test\Model;

use App\Model\Quote;

class QuoteTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsAssignedAddress()
    {
        $address = $this->getMock('App\Model\Address', ['load']);
        $address->expects($this->once())
            ->method('load')
            ->with($this->equalTo(42));
        $quote = new Quote(['address_id' => 42], null, null, $address);

        $quote->getAddress();
    }

    public function testCreatenewAddressIfNotAssigned()
    {
        $address = $this->getMock('App\Model\Address', ['getId', 'save']);
        $address->expects($this->once())
            ->method('save');
        $address->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(42));

        $quoteResource = $this->getMock('App\Model\IResourceEntity');
        $quote = new Quote();
        $quote = $this->getMock('App\Model\Quote', ['save'], [[], null, null, $address]);
        $quote->expects($this->once())
            ->method('save');
        $this->getAddress();
        $this->assertEquals(42, $this->getAddressId());
    }
}