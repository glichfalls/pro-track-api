<?php


namespace App\Controller;


use JsonSerializable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    
    /**
     * @param int                                $status
     * @param string                             $message
     * @param array|string|JsonSerializable|null $payload
     *
     * @return Response
     */
    protected function getJsonResponse(int $status, string $message = '', $payload = null) : Response
    {
        return $this->json([
            'status' => $status,
            'message' => $message,
            'payload' => $payload
        ], $status);
    }
    
}
