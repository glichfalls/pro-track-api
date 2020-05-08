<?php

namespace App\Entity;


use Symfony\Component\HttpFoundation\ParameterBag;

interface EntityInterface
{
    
    public function toArray() : array;
    
    public static function fromRequestValues(ParameterBag $input) : EntityInterface;
    
    public function applyRequestValues(ParameterBag $input) : EntityInterface;
    
}
