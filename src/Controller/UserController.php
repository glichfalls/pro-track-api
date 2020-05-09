<?php

namespace App\Controller;


use App\Exceptions\HTTPException;
use App\Exceptions\UnauthorizedException;
use App\Factory\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    
    public function authenticate(Request $request) : Response
    {
        try {
            $user = $this->userService->authenticateFromRequest($request);
            return ResponseFactory::createSuccessResponse('Anmeldung erfolgreich.', $user);
        } catch(UnauthorizedException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
    public function createUser(Request $request) : Response
    {
        try {
            $user = $this->userService->createUserFromRequest($request);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return ResponseFactory::createSuccessResponse(
                sprintf('Der Benutzer %s wurde erstellt.', $user->getName()),
                $user
            );
        } catch(HTTPException $exception) {
            return $exception->getJsonResponse();
        }
    }
    
}
