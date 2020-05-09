<?php

namespace App\Exceptions;


class InternalServerErrorException extends HTTPException
{

    public function getStatusCode() : int
    {
        return 500;
    }
    
}
