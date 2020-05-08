<?php


namespace App\Exceptions;


use App\Factory\ResponseFactory;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class HTTPException extends Exception
{
    
    protected ?array $payload;
    
    public function __construct($message, array $payload = [])
    {
        parent::__construct($message, 0, null);
        $this->payload = $payload;
    }
    
    public function getPayload() : array
    {
        return $this->payload;
    }
    
    public function getJsonResponse() : JsonResponse
    {
        return ResponseFactory::createJsonResponse($this->getStatusCode(), $this->getMessage(), $this->getPayload());
    }
    
    public abstract function getStatusCode() : int;
    
}
