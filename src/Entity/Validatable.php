<?php


namespace App\Entity;


use Symfony\Component\Validator\Mapping\ClassMetadata;

interface Validatable
{
    
    public static function loadValidatorMetadata(ClassMetadata $metadata) : void;
    
}
