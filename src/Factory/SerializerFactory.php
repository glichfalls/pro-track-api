<?php

namespace App\Factory;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    
    public static function getJsonSerializer() : Serializer
    {
        return new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
    }
    
}
