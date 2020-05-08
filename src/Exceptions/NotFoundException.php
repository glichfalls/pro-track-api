<?php


namespace App\Exceptions;


final class NotFoundException extends HTTPException
{
    
    public function getStatusCode() : int
    {
        return 404;
    }
    
}
