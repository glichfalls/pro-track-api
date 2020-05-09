<?php

namespace App\Entity;


use Symfony\Component\HttpFoundation\ParameterBag;

interface EntityInterface
{
    
    public function getId() : ?int;
    
    public static function fromRequestValues(ParameterBag $input) : EntityInterface;
    
    public function applyRequestValues(ParameterBag $input) : EntityInterface;
    
}
