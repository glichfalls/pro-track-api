<?php

namespace App\Factory;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseFactory
{
    
    private const STATUS_KEY = 'status';
    private const MESSAGE_KEY = 'message';
    private const PAYLOAD_KEY = 'payload';
    
    public static function createJsonResponse(
        int $status,
        string $message = '',
        $payload = null,
        array $headers = []
    ) : JsonResponse
    {
        return JsonResponse::create(null, $status, $headers)
            ->setJson(SerializerFactory::getJsonSerializer()->serialize([
                self::STATUS_KEY => $status,
                self::MESSAGE_KEY => $message,
                self::PAYLOAD_KEY => $payload
            ], 'json'));
    }
    
    public static function createSuccessResponse(
        string $message = '',
        $payload = null
    ) : Response
    {
        return $message === '' && $payload === null
            ? Response::create(null, 204)
            : self::createJsonResponse(200, $message, $payload);
    }

    /**
     * @param string $message
     *
     * @param array|null $payload
     * @return Response
     */
    public static function createServerErrorResponse(string $message, array $payload = null) : Response
    {
        return self::createJsonResponse(500, $message, $payload);
    }
    
}
