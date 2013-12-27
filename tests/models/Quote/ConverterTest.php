<?php

namespace Test\Model\Quote;

use App\Model\Quote;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertsQuoteToOrderUsingConverter()
    {
        $quote = new Quote;
        $order = new \App\Model\IOrder;

        $parkConverter = $this->getMock('\App\Model\Quotes\IConverter');
        $parkConverter->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($quote), $this->equalTo($order));

        $converterFactory = $this->getMock('\App\Model\Quote\ConverterFactory', ['getConverters']);

        $converterFactory->expects($this->once())
            ->method('getConverters')
            ->will($parkConverter);

        $converter = new \App\Model\Quote\Converter($converterFactory);

        $converter->toOrder($qoute, $order);
    }
}