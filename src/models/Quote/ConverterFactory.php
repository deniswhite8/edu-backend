<?php

namespace App\Model\Quote;


class ConverterFactory
{
    public function getConverters()
    {
        return [new AddressConverter(), new DataConverter(), new ItemsConverter()];
    }
} 