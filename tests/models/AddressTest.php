<?php

namespace Test\Model;

use App\Model\Address;

class AddressTest extends \PHPUnit_Framework_TestCase {

    public function testGetCityId()
    {
        $address = new Address(['city_id' => 17]);
        $this->assertEquals(17, $address->getCityId());
    }

    public function testGetRegionId()
    {
        $address = new Address(['region_id' => 16]);
        $this->assertEquals(16, $address->getRegionId(''));
    }

    public function testGetZipCode()
    {
        $address = new Address(['zip_code' => 123456]);
        $this->assertEquals(123456, $address->getZipCode());
    }

    public function testGetStreet()
    {
        $address = new Address(['street' => 'Lenina']);
        $this->assertEquals('Lenina', $address->getStreet());
    }

    public function testGetHouse()
    {
        $address = new Address(['house' => 15]);
        $this->assertEquals(15, $address->getHouse());
    }

    public function testGetFlat()
    {
        $address = new Address(['flat' => 1]);
        $this->assertEquals(1, $address->getFlat());
    }
} 