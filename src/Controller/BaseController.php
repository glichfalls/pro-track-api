<?php

namespace App\Controller;


use App\Entity\User;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseController extends AbstractController
{
    
    private ?User $user = null;
    protected UserService $userService;
    
    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }
    
    /**
     * @param Request $request
     *
     * @return User
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function getAuthenticatedUser(Request $request) : User
    {
        if($this->user) {
            return $this->user;
        }
        $user = null;
        if($request->request->has('user')) {
            $user = $request->request->get('user');
        }
        if($request->query->get('user')) {
            $user = $request->query->get('user');
        }
        if(!$user) {
            throw new ForbiddenException('Sie sind nicht authentifiziert.');
        }
        return $this->userService->getUserById($user);
    }
    
}
