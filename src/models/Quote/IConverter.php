<?php
namespace App\Model\Quote;


interface IConverter
{
    public function toOrder(Quote $quote, Order $order);
} 