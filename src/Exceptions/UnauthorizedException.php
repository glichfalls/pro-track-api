<?php

namespace App\Exceptions;


class UnauthorizedException extends HTTPException
{
    
    public function getStatusCode() : int
    {
        return 401;
    }
    
}
