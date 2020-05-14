<?php

namespace App\Utility;


use App\Entity\EntityInterface;

class Serializer
{
    
    public static function serializePayload($payload)
    {
        if($payload instanceof EntityInterface) {
            return $payload->toArray();
        }
        if(is_array($payload)) {
            return array_map(function($item) {
                if($item instanceof EntityInterface) {
                    return $item->toArray();
                }
                return $item;
            }, $payload);
        }
        return $payload;
    }
    
}
