<?php

namespace App\Controller;


use App\Entity\User;
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
     * @throws NotFoundException
     */
    public function getAuthenticatedUser(Request $request) : User
    {
        return $this->user ?: $this->userService->getUserById($request->request->get('user'));
    }
    
}
