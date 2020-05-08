<?php

namespace App\Exceptions;


final class BadRequestException extends HTTPException
{
    
    public function getStatusCode() : int
    {
        return 400;
    }

}
