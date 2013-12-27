<?php
namespace App\Model\Quote;


class Converter
{

    private $_converterFactory;

    public function __construct(\App\Model\Quote\CollectorsFactory $convertFactory)
    {
        $this->_convertFactory = $convertFactory;
    }

    public function toOrder(Quote $quote, Order $order)
    {
        foreach ($this->_converterFactory->getConverters() as $converter) {
            $converter->toOrder($order);
        }
    }
} 