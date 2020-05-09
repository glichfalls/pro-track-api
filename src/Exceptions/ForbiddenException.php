<?php

namespace App\Exceptions;


class ForbiddenException extends HTTPException
{
    
    public function getStatusCode() : int
    {
        return 403;
    }
    
}
