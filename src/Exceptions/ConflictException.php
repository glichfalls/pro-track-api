<?php


namespace App\Exceptions;


class ConflictException extends HTTPException
{
    
    public function getStatusCode() : int
    {
        return 409;
    }
    
}
