<?php

require_once __DIR__ . '/../src/models/Resource/IResourceCollection.php';
require_once __DIR__ . '/../src/models/ReviewCollection.php';

class ReviewCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['text' => 'lol']
                ]
            ));

        $collection = new ReviewCollection($resource);

        $products = $collection->getReviews();
        $this->assertEquals('lol', $products[0]->getText());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['text' => 'foo'],
                    ['text' => 'bar']
                ]
            ));

        $expected = array(0 => 'foo', 1 => 'bar');
        $collection = new ReviewCollection($resource);
        $iterated = false;



        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getText());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
}