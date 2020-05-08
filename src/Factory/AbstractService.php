<?php

namespace App\Factory;


use App\Entity\Validatable;
use App\Exceptions\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractService
{
    
    protected ValidatorInterface $validator;
    
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    /**
     * @param Validatable $entity
     *
     * @throws BadRequestException
     */
    protected function validateEntity(Validatable $entity) : void
    {
        $errors = $this->validator->validate($entity);
        if(count($errors) > 0) {
            throw new BadRequestException($errors->get(0)->getMessage());
        }
    }
    
}
