<?php

namespace App\Factory;


use App\Entity\EntityInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    
    public static function getJsonSerializer() : Serializer
    {
        $context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                if($object instanceof EntityInterface) {
                    return $object->getId();
                }
                return null;
            },
        ];
        $normalizer = new ObjectNormalizer(
            null,
            null,
            null,
            null,
            null,
            null,
            $context
        );
        return new Serializer(
            [$normalizer],
            [new JsonEncoder()]
        );
    }
    
}
